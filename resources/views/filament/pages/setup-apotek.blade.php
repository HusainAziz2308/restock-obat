<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}
        <div class="flex flex-wrap items-center gap-3 justify-start pt-4">
            <x-filament::button type="submit">
                Simpan & Siapkan Apotek
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>