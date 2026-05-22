<?php

namespace App\Filament\Resources\StockOutResource\Pages;

use App\Filament\Resources\StockOutResource;
use App\Models\Medicine;
use App\Models\StockMovement;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateStockOut extends CreateRecord
{
    protected static string $resource = StockOutResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }

    protected function beforeCreate(): void
    {
        $medicine = Medicine::query()
            ->lockForUpdate()
            ->find($this->data['medicine_id'] ?? null);
        $quantity = (int) ($this->data['quantity'] ?? 0);

        if (! $medicine) {
            return;
        }

        if ($quantity > $medicine->stock) {
            Notification::make()
                ->title('Stok tidak mencukupi')
                ->body("Stok {$medicine->name} saat ini hanya {$medicine->stock}.")
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        $medicine = $this->record->medicine()->lockForUpdate()->first();
        $beforeStock = $medicine->stock;

        $medicine->decrement('stock', $this->record->quantity);
        $medicine->refresh();

        StockMovement::create([
            'medicine_id' => $medicine->id,
            'type' => 'out',
            'quantity' => $this->record->quantity,
            'before_stock' => $beforeStock,
            'after_stock' => $medicine->stock,
            'source_type' => $this->record::class,
            'source_id' => $this->record->id,
            'note' => $this->record->reason . ($this->record->note ? ': ' . $this->record->note : ''),
            'created_by' => $this->record->created_by,
        ]);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Barang keluar berhasil dicatat';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
