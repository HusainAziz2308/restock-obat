@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-md">

    <h1 class="text-2xl font-bold text-green-600 mb-4">
        💊 {{ $product['nama'] }}
    </h1>

    <p class="text-lg text-green-500 font-semibold">
        Rp {{ number_format($product['harga'], 0, ',', '.') }}
    </p>

    <div class="mt-4 p-4 bg-slate-100 rounded-lg">
        <p class="text-slate-700">
            {{ $product['deskripsi'] }}
        </p>
    </div>

    <a href="/katalog"
        class="inline-block mt-6 text-blue-500 hover:underline">
        ← Kembali ke katalog
    </a>

</div>

@endsection