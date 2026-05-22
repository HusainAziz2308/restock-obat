<?php

namespace App\Filament\Widgets;

use App\Models\Medicine;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LowStockMedicines extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Obat Perlu Restock')
            ->description('Daftar obat dengan stok sama dengan atau di bawah stok minimum.')
            ->query(
                Medicine::query()
                    ->whereColumn('stock', '<=', 'min_stock')
                    ->orderBy('stock')
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
                    ->badge()
                    ->color(fn(int $state): string => $state <= 0 ? 'danger' : 'warning')
                    ->sortable(),
                TextColumn::make('min_stock')
                    ->label('Stok Minimum')
                    ->sortable(),
                TextColumn::make('stock_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Habis' => 'danger',
                        'Perlu Restock' => 'warning',
                        default => 'success',
                    }),
            ])
            ->emptyStateHeading('Tidak ada obat yang perlu restock')
            ->emptyStateDescription('Semua stok obat masih berada di atas stok minimum.');
    }
}
