<?php

namespace App\Filament\Widgets;

use App\Models\Medicine;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class ExpiringMedicines extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Obat Mendekati Kedaluwarsa')
            ->description('Obat yang sudah kedaluwarsa atau akan kedaluwarsa dalam 30 hari.')
            ->query(
                Medicine::query()
                    ->whereNotNull('expired_date')
                    ->whereDate('expired_date', '<=', now()->addDays(30))
                    ->orderBy('expired_date')
            )
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Obat')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->placeholder('-'),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable(),
                TextColumn::make('expired_date')
                    ->label('Kedaluwarsa')
                    ->date()
                    ->badge()
                    ->color(fn (Medicine $record): string => $record->expired_date?->isPast() ? 'danger' : 'warning')
                    ->sortable(),
            ])
            ->emptyStateHeading('Tidak ada obat yang mendekati kedaluwarsa')
            ->emptyStateDescription('Tidak ada obat yang kedaluwarsa dalam 30 hari ke depan.');
    }
}
