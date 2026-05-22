<?php

namespace App\Filament\Widgets;

use App\Models\Restock;
use Filament\Widgets\ChartWidget;

class RestockMonthlyChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Tren Restock 6 Bulan';

    protected ?string $description = 'Jumlah transaksi dan total item masuk per bulan.';

    protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn (int $monthOffset) => now()->subMonths($monthOffset));

        return [
            'datasets' => [
                [
                    'label' => 'Transaksi Restock',
                    'data' => $months->map(fn ($date) => Restock::query()
                        ->whereMonth('restock_date', $date->month)
                        ->whereYear('restock_date', $date->year)
                        ->count())->all(),
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                ],
                [
                    'label' => 'Item Masuk',
                    'data' => $months->map(fn ($date) => Restock::query()
                        ->whereMonth('restock_date', $date->month)
                        ->whereYear('restock_date', $date->year)
                        ->sum('quantity'))->all(),
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#059669',
                ],
            ],
            'labels' => $months->map(fn ($date) => $date->translatedFormat('M Y'))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
