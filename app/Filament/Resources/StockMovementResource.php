<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockMovementResource\Pages;
use App\Models\StockMovement;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StockMovementResource extends Resource
{
    protected static ?string $model = StockMovement::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Mutasi Stok';

    protected static ?string $modelLabel = 'Mutasi Stok';

    protected static ?string $pluralModelLabel = 'Mutasi Stok';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('medicine.code')
                    ->label('Kode Obat')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('medicine.name')
                    ->label('Nama Obat')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn (string $state): string => StockMovement::TYPES[$state] ?? $state)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                        'adjustment' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('quantity')
                    ->label('Qty')
                    ->badge()
                    ->color(fn (StockMovement $record): string => $record->type === 'out' ? 'danger' : 'success')
                    ->sortable(),
                TextColumn::make('before_stock')
                    ->label('Sebelum')
                    ->sortable(),
                TextColumn::make('after_stock')
                    ->label('Sesudah')
                    ->sortable(),
                TextColumn::make('note')
                    ->label('Catatan')
                    ->limit(40)
                    ->placeholder('-'),
                TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('medicine_id')
                    ->label('Obat')
                    ->relationship('medicine', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options(StockMovement::TYPES),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockMovements::route('/'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['pharmacy_id'] = auth()->user()->pharmacy_id;
        return $data;
    }
}
