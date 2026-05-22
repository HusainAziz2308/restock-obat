<?php

namespace App\Filament\Widgets;

use App\Models\Medicine;
use App\Models\Restock;
use App\Models\StockOut;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PenjualanStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Ringkasan Inventory';

    protected ?string $description = 'Pantauan cepat stok obat, restock, dan barang keluar.';

    protected function getStats(): array
    {
        $lowStock = Medicine::query()
            ->whereColumn('stock', '<=', 'min_stock')
            ->count();

        $emptyStock = Medicine::query()
            ->where('stock', '<=', 0)
            ->count();

        $restockThisMonth = Restock::query()
            ->whereMonth('restock_date', now()->month)
            ->whereYear('restock_date', now()->year);

        $stockOutThisMonth = StockOut::query()
            ->whereMonth('out_date', now()->month)
            ->whereYear('out_date', now()->year);

        return [
            Stat::make('Total Obat', Medicine::query()->count())
                ->description('Data obat aktif')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('info'),

            Stat::make('Perlu Restock', $lowStock)
                ->description('Stok <= stok minimum')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStock > 0 ? 'warning' : 'success'),

            Stat::make('Stok Habis', $emptyStock)
                ->description('Obat dengan stok 0')
                ->descriptionIcon('heroicon-m-no-symbol')
                ->color($emptyStock > 0 ? 'danger' : 'success'),

            Stat::make('Restock Bulan Ini', (clone $restockThisMonth)->count())
                ->description('Jumlah transaksi restock')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('success'),

            Stat::make('Item Masuk Bulan Ini', (clone $restockThisMonth)->sum('quantity'))
                ->description('Total kuantitas restock')
                ->descriptionIcon('heroicon-m-cube')
                ->color('success'),

            Stat::make('Item Keluar Bulan Ini', (clone $stockOutThisMonth)->sum('quantity'))
                ->description((clone $stockOutThisMonth)->count() . ' transaksi barang keluar')
                ->descriptionIcon('heroicon-m-arrow-up-tray')
                ->color('danger'),
        ];
    }
}
