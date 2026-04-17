@extends('layouts.main')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang di Restock Obat!</h1>
    <p class="text-gray-600 leading-relaxed mb-6">
        Satu2 nya website penjualan obat yang menyediakan fitur restock untuk memastikan apotek Anda selalu memiliki stok yang cukup. Dengan Restock Obat, Anda dapat dengan mudah memantau stok obat, melakukan restock secara efisien, dan menjaga kepuasan pelanggan.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
            <h3 class="font-bold text-blue-700">Total Obat</h3>
            <p class="text-2xl font-black text-blue-900">120 Item</p>
        </div>
        <div class="bg-green-50 p-6 rounded-xl border border-green-100">
            <h3 class="font-bold text-green-700">Total Pengguna</h3>
            <p class="text-2xl font-black text-green-900">100000</p>
        </div>
        <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-100">
            <h3 class="font-bold text-yellow-700">Total Upload Resep</h3>
            <p class="text-2xl font-black text-yellow-900">958 Item</p>
        </div>
    </div>
</div>
@endsection
