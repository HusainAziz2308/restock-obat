<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicineResource\Pages;
use App\Models\Medicine;
use App\Models\Restock;
use App\Models\StockMovement;
use BackedEnum;
use UnitEnum;
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
use Illuminate\Support\Facades\DB;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-beaker';

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 1;

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
                            ->disabled(fn (?Medicine $record): bool => $record !== null)
                            ->dehydrated(fn (?Medicine $record): bool => $record === null)
                            ->helperText('Stok awal hanya diisi saat tambah obat. Setelah itu ubah stok lewat Restock, Barang Keluar, atau Koreksi Stok.'),
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

                        DB::transaction(function () use ($record, $quantity, $data): void {
                            $medicine = Medicine::query()
                                ->lockForUpdate()
                                ->findOrFail($record->id);
                            $beforeStock = $medicine->stock;

                            $restock = Restock::create([
                                'medicine_id' => $medicine->id,
                                'quantity' => $quantity,
                                'restock_date' => now()->toDateString(),
                                'note' => $data['note'] ?? null,
                                'created_by' => auth()->id(),
                            ]);

                            $medicine->increment('stock', $quantity);
                            $medicine->refresh();

                            StockMovement::create([
                                'medicine_id' => $medicine->id,
                                'type' => 'in',
                                'quantity' => $quantity,
                                'before_stock' => $beforeStock,
                                'after_stock' => $medicine->stock,
                                'source_type' => $restock::class,
                                'source_id' => $restock->id,
                                'note' => $restock->note,
                                'created_by' => $restock->created_by,
                            ]);

                            $record->setRawAttributes($medicine->getAttributes(), true);
                        });

                        Notification::make()
                            ->title('Restock berhasil')
                            ->body("{$record->name}: stok {$oldStock} + {$quantity} = {$record->stock}.")
                            ->success()
                            ->send();
                    }),
                Action::make('stockOpname')
                    ->label('Stock Opname')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('warning')
                    ->modalHeading(fn (Medicine $record): string => 'Stock Opname ' . $record->name)
                    ->modalDescription(fn (Medicine $record): string => "Stok sistem saat ini: {$record->stock}.")
                    ->modalSubmitActionLabel('Simpan Koreksi')
                    ->form([
                        TextInput::make('actual_count')
                            ->label('Jumlah Fisik Aktual')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->helperText('Isi jumlah stok hasil hitung fisik di rak/gudang.'),
                        Textarea::make('note')
                            ->label('Catatan')
                            ->placeholder('Opsional: alasan koreksi stok'),
                    ])
                    ->action(function (Medicine $record, array $data): void {
                        DB::transaction(function () use ($record, $data): void {
                            $medicine = Medicine::query()
                                ->lockForUpdate()
                                ->findOrFail($record->id);

                            $beforeStock = $medicine->stock;
                            $actualCount = (int) $data['actual_count'];
                            $difference = $actualCount - $beforeStock;

                            if ($difference === 0) {
                                Notification::make()
                                    ->title('Tidak ada selisih')
                                    ->body("Stok {$medicine->name} sudah sesuai: {$beforeStock}.")
                                    ->warning()
                                    ->send();

                                return;
                            }

                            $medicine->update(['stock' => $actualCount]);

                            StockMovement::create([
                                'medicine_id' => $medicine->id,
                                'type' => 'adjustment',
                                'quantity' => abs($difference),
                                'before_stock' => $beforeStock,
                                'after_stock' => $actualCount,
                                'note' => ($data['note'] ?? null) ?: 'Stock Opname: ' . ($difference > 0 ? '+' : '') . $difference,
                                'created_by' => auth()->id(),
                            ]);

                            $record->setRawAttributes($medicine->getAttributes(), true);
                        });

                        Notification::make()
                            ->title('Stock opname berhasil')
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
