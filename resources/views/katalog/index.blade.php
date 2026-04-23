@extends('layouts.main')

@section('content')

<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            💊 Katalog Obat
        </h1>

        <a href="/katalog/create"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold shadow-sm">
            + Tambah Obat
        </a>

    </div>
    <p class="mb-4 text-red-600">
        Total Produk: {{ $products->count() }}
    </p>

    <form action="/katalog/search" method="GET" class="flex gap-3 mb-8">
        <input
            type="text"
            name="keyword"
            placeholder="Cari obat..."
            class="border border-gray-300 rounded-lg px-4 py-3 w-80">

        <button
            class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700">
            Cari
        </button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($products as $product)
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
            <img src="{{ asset('images/obat/' . $product->image) }}"
                class="w-full h-40 object-cover rounded-xl mb-4">
            <h3 class="font-bold text-gray-800 text-xl mb-2">
                {{ $product->name }}
            </h3>

            <p class="text-gray-600 mb-1">
                Harga: Rp {{ number_format($product->price,0,',','.') }}
            </p>

            <p class="text-gray-600 mb-4">
                Stok: {{ $product->stock }}
            </p>

            <a href="/katalog/{{ $product->id }}"
                class="text-blue-600 font-semibold hover:underline">
                Lihat Detail
            </a>

        </div>
        @endforeach

    </div>

</div>

@endsection