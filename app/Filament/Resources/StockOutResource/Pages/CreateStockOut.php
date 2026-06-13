<?php

namespace App\Filament\Resources\StockOutResource\Pages;

use App\Filament\Resources\StockOutResource;
use App\Models\Medicine;
use App\Models\StockMovement;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateStockOut extends CreateRecord
{
    protected static string $resource = StockOutResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }

    /**
     * Atomic stock-out: lock medicine, validate stock, create record,
     * decrement stock, and log movement in a single transaction so two
     * concurrent stock-outs can't both pass the check and oversell stock.
     */
    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $medicine = Medicine::query()
                ->lockForUpdate()
                ->find($data['medicine_id'] ?? null);

            if (! $medicine) {
                Notification::make()
                    ->title('Obat tidak ditemukan')
                    ->danger()
                    ->send();

                throw new Halt();
            }

            $quantity = (int) ($data['quantity'] ?? 0);

            if ($quantity > $medicine->stock) {
                Notification::make()
                    ->title('Stok tidak mencukupi')
                    ->body("Stok {$medicine->name} saat ini hanya {$medicine->stock}.")
                    ->danger()
                    ->send();

                throw new Halt();
            }

            $beforeStock = $medicine->stock;

            $record = static::getModel()::create($data);

            $medicine->decrement('stock', $quantity);
            $medicine->refresh();

            StockMovement::create([
                'medicine_id' => $medicine->id,
                'type' => 'out',
                'quantity' => $quantity,
                'before_stock' => $beforeStock,
                'after_stock' => $medicine->stock,
                'source_type' => $record::class,
                'source_id' => $record->id,
                'note' => $record->reason . ($record->note ? ': ' . $record->note : ''),
                'created_by' => $record->created_by,
            ]);

            return $record;
        });
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
