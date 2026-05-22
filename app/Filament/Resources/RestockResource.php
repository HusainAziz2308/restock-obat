<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestockResource\Pages;
use App\Models\Restock;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RestockResource extends Resource
{
    protected static ?string $model = Restock::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Restock';

    protected static ?string $modelLabel = 'Restock';

    protected static ?string $pluralModelLabel = 'Restock';

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::whereMonth('restock_date', now()->month)
            ->whereYear('restock_date', now()->year)
            ->count();
    }

    public static function getNavigationBadgeTooltip(): \Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'Jumlah restock bulan ini';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Restock')
                    ->schema([
                        Select::make('medicine_id')
                            ->label('Obat')
                            ->relationship('medicine', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Jumlah Masuk')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->helperText('Jumlah ini akan ditambahkan ke stok obat.'),
                        DatePicker::make('restock_date')
                            ->label('Tanggal Restock')
                            ->default(now())
                            ->required(),
                        Textarea::make('note')
                            ->label('Catatan')
                            ->placeholder('Opsional: keterangan restock')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('restock_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('medicine.code')
                    ->label('Kode Obat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('medicine.name')
                    ->label('Nama Obat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Jumlah Masuk')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->summarize(Sum::make()->label('Total Masuk')),
                TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('note')
                    ->label('Catatan')
                    ->limit(40)
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Dicatat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('medicine_id')
                    ->label('Obat')
                    ->relationship('medicine', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('restock_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRestocks::route('/'),
            'create' => Pages\CreateRestock::route('/create'),
        ];
    }
}
