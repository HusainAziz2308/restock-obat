@extends('layouts.main')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    💊 Katalog Obat
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($products as $item)
    <div class="bg-white rounded-2xl shadow-md p-5 hover:shadow-lg transition">

        <h2 class="text-lg font-bold">
            {{ $item['nama'] }}
        </h2>

        <p class="text-blue-600 mt-2 font-semibold">
            Rp {{ number_format($item['harga'], 0, ',', '.') }}
        </p>

        <a href="/katalog/{{ $item['id'] }}"
           class="block mt-4 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700">
           Detail
        </a>

    </div>
    @endforeach

</div>

@endsection
