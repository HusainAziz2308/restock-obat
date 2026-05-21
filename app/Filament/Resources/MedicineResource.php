<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicineResource\Pages;
use App\Models\Medicine;
use App\Models\Restock;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationLabel = 'Obat';

    protected static ?string $modelLabel = 'Obat';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Obat')
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode Obat')
                            ->required(true)
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('name')
                            ->label('Nama Obat')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->label('Harga')
                            ->numeric()
                            ->required(true)
                            ->minValue(0)
                            ->prefix('Rp'),
                        TextInput::make('stock')
                            ->label('Stok')
                            ->numeric()
                            ->required(true)
                            ->minValue(0)
                            ->helperText('Jumlah stok obat saat ini.'),
                        TextInput::make('min_stock')
                            ->label('Stok Minimum')
                            ->numeric()
                            ->required(true)
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Obat ditandai perlu restock jika stok sama dengan atau di bawah angka ini.'),
                        DatePicker::make('expired_date')
                            ->required(true)
                            ->label('Tanggal Kedaluwarsa'),
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('unit_id')
                            ->label('Satuan')
                            ->relationship('unit', 'name')
                            ->searchable()
                            ->preload(),
                        FileUpload::make('image')
                            ->label('Foto (Maksimal 5 mb)')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->directory('obat')
                            ->disk('public')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Foto')
                    ->square(),
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Obat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('unit.name')
                    ->label('Satuan')
                    ->placeholder('-'),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable(),
                TextColumn::make('min_stock')
                    ->label('Stok Minimum')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('stock_status')
                    ->label('Status Stok')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Habis' => 'danger',
                        'Perlu Restock' => 'warning',
                        default => 'success',
                    }),
                TextColumn::make('expired_date')
                    ->label('Kedaluwarsa')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('perlu_restock')
                    ->label('Perlu Restock')
                    ->query(fn (Builder $query): Builder => $query->whereColumn('stock', '<=', 'min_stock')),
            ])
            ->actions([
                Action::make('restock')
                    ->label('Restock')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->modalHeading(fn (Medicine $record): string => 'Restock ' . $record->name)
                    ->modalDescription(fn (Medicine $record): string => "Stok saat ini: {$record->stock}. Stok minimum: {$record->min_stock}.")
                    ->modalSubmitActionLabel('Tambah Stok')
                    ->form([
                        TextInput::make('quantity')
                            ->label('Jumlah Restock')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->placeholder('Contoh: 25')
                            ->helperText('Jumlah ini akan langsung ditambahkan ke stok obat saat ini.'),
                        Textarea::make('note')
                            ->label('Catatan')
                            ->placeholder('Opsional: keterangan restock'),
                    ])
                    ->action(function (Medicine $record, array $data): void {
                        $quantity = (int) $data['quantity'];
                        $oldStock = $record->stock;

                        Restock::create([
                            'medicine_id' => $record->id,
                            'quantity' => $quantity,
                            'restock_date' => now()->toDateString(),
                            'note' => $data['note'] ?? null,
                            'created_by' => auth()->id(),
                        ]);

                        $record->increment('stock', $quantity);
                        $record->refresh();

                        Notification::make()
                            ->title('Restock berhasil')
                            ->body("{$record->name}: stok {$oldStock} + {$quantity} = {$record->stock}.")
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }
}
