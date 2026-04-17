@extends('layouts.main')

@section('content')

<div class="max-w-lg mx-auto bg-white p-6 rounded-2xl shadow-md">

    <h1 class="text-2xl font-bold text-green-600 mb-6">
        ➕ Tambah Produk
    </h1>

    <form action="#" method="POST" class="space-y-4">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Nama Obat</label>
            <input type="text" name="nama"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none"
                   placeholder="Masukkan nama obat">
        </div>

        {{-- Harga --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Harga</label>
            <input type="number" name="harga"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none"
                   placeholder="Masukkan harga">
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi"
                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none"
                      placeholder="Deskripsi obat"></textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-between items-center mt-4">
            <a href="/katalog" class="text-slate-500 hover:underline">
                ← Kembali
            </a>

            <button type="submit"
                    class="px-5 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                Simpan
            </button>
        </div>

    </form>

</div>

@endsection
