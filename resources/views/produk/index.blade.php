@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-green-600 mb-6">
    💊 Katalog Obat
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($products as $item)
    <div class="bg-white rounded-2xl shadow-md p-5 hover:shadow-lg transition">

        <h2 class="text-lg font-bold">
            {{ $item['nama'] }}
        </h2>

        <p class="text-green-600 mt-2 font-semibold">
            Rp {{ number_format($item['harga'], 0, ',', '.') }}
        </p>

        <a href="/katalog/{{ $item['id'] }}"
           class="block mt-4 bg-green-500 text-white text-center py-2 rounded-lg hover:bg-green-600">
           Detail
        </a>

    </div>
    @endforeach

</div>

@endsection