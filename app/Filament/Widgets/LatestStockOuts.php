<?php

namespace App\Filament\Widgets;

use App\Models\StockOut;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestStockOuts extends TableWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Barang Keluar Terbaru')
            ->description('Transaksi stok keluar yang baru dicatat.')
            ->query(
                StockOut::query()
                    ->latest('out_date')
                    ->latest('created_at')
            )
            ->columns([
                TextColumn::make('out_date')
                    ->label('Tanggal')
                    ->date(),
                TextColumn::make('medicine.name')
                    ->label('Nama Obat')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->badge()
                    ->color('danger'),
                TextColumn::make('reason')
                    ->label('Alasan')
                    ->badge(),
                TextColumn::make('creator.name')
                    ->label('Dicatat Oleh')
                    ->placeholder('-'),
            ])
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('Belum ada transaksi barang keluar')
            ->emptyStateDescription('Transaksi barang keluar akan muncul di sini setelah dicatat.');
    }
}
