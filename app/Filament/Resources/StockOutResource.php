<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockOutResource\Pages;
use App\Models\StockOut;
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

class StockOutResource extends Resource
{
    protected static ?string $model = StockOut::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-up-tray';

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Barang Keluar';

    protected static ?string $modelLabel = 'Barang Keluar';

    protected static ?string $pluralModelLabel = 'Barang Keluar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Barang Keluar')
                    ->schema([
                        Select::make('medicine_id')
                            ->label('Obat')
                            ->relationship('medicine', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Jumlah Keluar')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->helperText('Jumlah tidak boleh melebihi stok obat saat ini.'),
                        DatePicker::make('out_date')
                            ->label('Tanggal Keluar')
                            ->default(now())
                            ->required(),
                        Select::make('reason')
                            ->label('Alasan Keluar')
                            ->options(StockOut::REASONS)
                            ->default('Terjual')
                            ->required(),
                        Textarea::make('note')
                            ->label('Catatan')
                            ->placeholder('Opsional: keterangan barang keluar')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('out_date')
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
                    ->label('Jumlah Keluar')
                    ->badge()
                    ->color('danger')
                    ->sortable()
                    ->summarize(Sum::make()->label('Total Keluar')),
                TextColumn::make('reason')
                    ->label('Alasan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Terjual' => 'success',
                        'Rusak', 'Expired' => 'danger',
                        'Koreksi Stok' => 'warning',
                        default => 'gray',
                    }),
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
                SelectFilter::make('reason')
                    ->label('Alasan')
                    ->options(StockOut::REASONS),
            ])
            ->defaultSort('out_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockOuts::route('/'),
            'create' => Pages\CreateStockOut::route('/create'),
        ];
    }
}
