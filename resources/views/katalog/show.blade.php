@extends('layouts.main')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">

    <div class="grid grid-cols-2 gap-8 items-start">

        {{-- KOLOM KIRI : GAMBAR --}}
        <div class="bg-gray-50 rounded-2xl flex justify-center items-center" style="min-height: 240px;">
            <img
                src="{{ $product->image ? asset('images/obat/' . $product->image) : 'https://placehold.co/300x300?text=No+Image' }}"
                style="width: 260px; height: 260px; object-fit: contain;"
                alt="{{ $product->name }}">
        </div>

        {{-- KOLOM KANAN : INFO --}}
        <div>

            <p class="text-sm font-semibold text-blue-600 mb-2">
                {{ $product->code }}
            </p>

            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                {{ $product->name }}
            </h1>

            <p class="text-2xl font-black text-green-600 mb-6">
                Rp {{ number_format($product->price,0,',','.') }}
            </p>

            <div class="space-y-3 text-gray-700 mb-8">

                <div class="flex justify-between border-b pb-2">
                    <span class="font-semibold">Stok</span>
                    <span>{{ $product->stock }}</span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="font-semibold">Expired</span>
                    <span>{{ $product->expired_date }}</span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="font-semibold">Status Stok</span>

                    @if($product->stock > 20)
                    <span class="text-green-600 font-semibold">Aman</span>
                    @elseif($product->stock > 5)
                    <span class="text-yellow-600 font-semibold">Menipis</span>
                    @elseif($product->stock > 0)
                    <span class="text-red-500 font-semibold">Kritis</span>
                    @else
                    <span class="text-red-700 font-semibold">Habis</span>
                    @endif

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3">

                <a href="/katalog"
                    class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl font-semibold">
                    Kembali
                </a>

                <a href="/katalog/{{ $product->id }}/edit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">
                    Edit Data
                </a>

            </div>

        </div>

    </div>

</div>

@endsection