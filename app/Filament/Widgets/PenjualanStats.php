<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PenjualanStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Revenue', 'Rp ' . number_format(15000000, 0, ',', '.'))
                ->description('Total pendapatan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Barang Masuk', '150 Pcs')
                ->description('Stok obat baru')
                ->color('info'),

            Stat::make('Barang Keluar', '45 Pcs')
                ->description('Obat terjual hari ini')
                ->color('danger'),
        ];
    }
}
