@extends('layouts.main')

@section('content')

<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            ✏️ Edit Data Obat
        </h1>

        <p class="text-gray-600">
            Halaman ini digunakan untuk memperbarui informasi obat yang sudah terdaftar.
            Anda dapat mengubah nama obat, harga, jumlah stok, tanggal kedaluwarsa,
            dan mengganti foto produk.
        </p>
    </div>

    <form action="{{ route('katalog.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

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
                        value="{{ $product->code }}"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Contoh: OBT001">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Nama Obat
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ $product->name }}"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Contoh: Paracetamol">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Harga
                    </label>
                    <input
                        type="number"
                        name="price"
                        value="{{ $product->price }}"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Contoh: 5000">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Jumlah Stok
                    </label>
                    <input
                        type="number"
                        name="stock"
                        value="{{ $product->stock }}"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Contoh: 50">
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-5">

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Kedaluwarsa
                    </label>
                    <input
                        type="date"
                        name="expired_date"
                        value="{{ $product->expired_date }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Foto Saat Ini
                    </label>

                    <div class="bg-gray-50 border rounded-2xl p-3 flex justify-center">
                        <img
                            src="{{ $product->image_url }}"
                            style="width:110px; height:110px; object-fit:contain;"
                            class="mx-auto">
                    </div>

                    <p class="text-sm text-gray-500 mt-2">
                        File saat ini: {{ $product->image }}
                    </p>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Upload Foto Baru
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="w-full border rounded-xl px-4 py-3 bg-white">

                    <p class="text-sm text-gray-500 mt-2">
                        Format yang disarankan: JPG / PNG.
                    </p>
                </div>

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="pt-4 flex gap-3">

            <a href="/katalog/{{ $product->id }}"
                class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl font-semibold">
                Batal
            </a>

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection