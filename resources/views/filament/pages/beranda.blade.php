<x-filament-panels::page>
    <div class="text-center">
        <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
            Selamat datang, {{ auth()->user()->name }}! 👋
        </h2>

        {{-- 👇 Tambahan badge penanda Role di sini 👇 --}}
        <div class="mt-2">
            <span
                class="inline-flex items-center px-3 py-1 text-sm font-medium text-primary-700 bg-primary-100 rounded-full dark:text-primary-400 dark:bg-primary-900/30">
                Login sebagai: {{ auth()->user()->roles->pluck('name')->implode(', ') }}
            </span>
        </div>

        <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
            Selamat bekerja dan tetap semangat. Pastikan selalu teliti dalam mengecek stok dan mengelola data obat hari
            ini.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 mt-6">
            {{-- Tombol Lanjut ke Menu Obat --}}
            <x-filament::button tag="a" href="{{ \App\Filament\Resources\MedicineResource::getUrl('index') }}"
                size="lg" color="primary">
                Lanjut ke Data Obat
            </x-filament::button>

            {{-- Tombol Lanjut ke Kategori (Opsional, hapus jika tidak perlu) --}}
            <x-filament::button tag="a" href="{{ \App\Filament\Resources\CategoryResource::getUrl('index') }}"
                size="lg" color="gray" variant="outlined">
                Lihat Kategori
            </x-filament::button>
        </div>

    </div>
</x-filament-panels::page>
