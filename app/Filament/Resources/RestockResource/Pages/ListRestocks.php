<?php

namespace App\Filament\Resources\RestockResource\Pages;

use App\Filament\Resources\RestockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRestocks extends ListRecords
{
    protected static string $resource = RestockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->url(route('admin.export.restocks'))
                ->openUrlInNewTab(),
            Actions\CreateAction::make(),
        ];
    }
}
