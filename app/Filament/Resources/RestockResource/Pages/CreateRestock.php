<?php

namespace App\Filament\Resources\RestockResource\Pages;

use App\Filament\Resources\RestockResource;
use App\Models\StockMovement;
use Filament\Resources\Pages\CreateRecord;

class CreateRestock extends CreateRecord
{
    protected static string $resource = RestockResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $medicine = $this->record->medicine()->lockForUpdate()->first();
        $beforeStock = $medicine->stock;

        $medicine->increment('stock', $this->record->quantity);
        $medicine->refresh();

        StockMovement::create([
            'medicine_id' => $medicine->id,
            'type' => 'in',
            'quantity' => $this->record->quantity,
            'before_stock' => $beforeStock,
            'after_stock' => $medicine->stock,
            'source_type' => $this->record::class,
            'source_id' => $this->record->id,
            'note' => $this->record->note,
            'created_by' => $this->record->created_by,
        ]);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Restock berhasil dicatat';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
