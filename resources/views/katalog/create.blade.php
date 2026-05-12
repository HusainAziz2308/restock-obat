@extends('layouts.main')

@section('content')

<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            ➕ Tambah Obat Baru
        </h1>

        <p class="text-gray-600">
            Lengkapi data obat sesuai database sistem. Setelah disimpan,
            produk akan otomatis tampil di katalog.
        </p>
    </div>

    <form action="{{ route('katalog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-8">

            {{-- KOLOM KIRI --}}
            <div class="space-y-5">

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Kode Obat
                    </label>
                    <input
                        type="text"
                        name="code"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Contoh: OBT011"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Nama Obat
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Contoh: Paracetamol"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Harga
                    </label>
                    <input
                        type="number"
                        name="price"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Contoh: 5000"
                        required>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-5">

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Jumlah Stok
                    </label>
                    <input
                        type="number"
                        name="stock"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Contoh: 50"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Kedaluwarsa
                    </label>
                    <input
                        type="date"
                        name="expired_date"
                        class="w-full border rounded-xl px-4 py-3"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload Foto
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="w-full border rounded-xl px-4 py-3 bg-white">

                    <p class="text-sm text-gray-500 mt-2">
                        Format gambar: JPG / PNG
                    </p>
                </div>

            </div>

        </div>

        {{-- INFO PANEL --}}
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-sm text-blue-700">
            Pastikan kode obat unik dan stok awal sesuai jumlah barang masuk.
        </div>

        {{-- BUTTON --}}
        <div class="pt-2 flex gap-3">

            <a href="/katalog"
                class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl font-semibold">
                Batal
            </a>

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">
                Simpan Data
            </button>

        </div>

    </form>

</div>

@endsection