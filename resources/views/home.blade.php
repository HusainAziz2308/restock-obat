@extends('layouts.app')

@section('title', 'Selamat Datang di Restock Obat')

@section('content')

<div x-data="{ activeSlide: 0, slideCount: {{ count($sliders) }} }" class="relative h-screen w-full overflow-hidden bg-slate-900">

    <div class="relative w-full h-full">
        @foreach ($sliders as $index => $slide)
        <div x-show="activeSlide === {{ $index }}"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 transform scale-105"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 w-full h-full">

            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-slate-900/90 z-10"></div>

            <img src="{{ $slide['image'] }}" class="object-cover w-full h-full absolute inset-0" alt="Slider Image">

            <div class="relative z-20 flex flex-col items-center justify-center h-full text-center px-4 max-w-4xl mx-auto text-white">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                    {{ $slide['title'] }}
                </h1>
                <p class="text-base md:text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    {{ $slide['subtitle'] }}
                </p>
                <div class="flex gap-4">
                    <a href="/admin/login" class="px-8 py-3.5 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-lg transition-all duration-200">
                        Mulai Kelola
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button @click="activeSlide = (activeSlide === 0) ? slideCount - 1 : activeSlide - 1"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-30 bg-white/10 hover:bg-white/20 p-3 rounded-full text-white backdrop-blur-sm transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    
    <button @click="activeSlide = (activeSlide === slideCount - 1) ? 0 : activeSlide + 1"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-30 bg-white/10 hover:bg-white/20 p-3 rounded-full text-white backdrop-blur-sm transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex gap-2">
        @foreach ($sliders as $index => $slide)
        <button @click="activeSlide = {{ $index }}"
                :class="activeSlide === {{ $index }} ? 'bg-blue-600 w-8' : 'bg-white/40 w-2'"
                class="h-2 rounded-full transition-all duration-300"></button>
        @endforeach
    </div>
</div>
@endsection