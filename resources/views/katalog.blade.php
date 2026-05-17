@extends('layouts.app')

@section('title', 'Katalog Layanan')

@section('page_title', 'Pilih Layanan Anda')
@section('page_description', 'Tingkatkan efisiensi inventaris farmasi Anda dengan sistem manajemen gudang cerdas kami. Tidak ada biaya tersembunyi, batalkan kapan saja.')

@section('content')
    @include('partials.page-header')
    <section class="py-24 bg-slate-50 min-h-screen">
        <div class="max-w-full mx-auto px-6 md:px-12">
            
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold text-sm uppercase tracking-wider block mb-2">Katalog Layanan WMS</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Pilih Paket Sesuai Skala Gudang Anda
                </h2>
                <p class="text-slate-500 max-w-2xl mx-auto">
                    Tingkatkan efisiensi inventaris farmasi Anda dengan sistem manajemen gudang cerdas kami. Tidak ada biaya tersembunyi, batalkan kapan saja.
                </p>
            </div>

            <div class="flex flex-col md:flex-row justify-center gap-8 max-w-7xl mx-auto items-center md:items-stretch">
                @foreach ($packages as $package)
                    
                    <div class="{{ $package['is_featured'] ? 'bg-blue-600 rounded-3xl p-8 border border-blue-600 shadow-2xl transform md:-translate-y-5 hover:-translate-y-10 transition-all duration-300 relative' : 'bg-white rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-5 transition-all duration-300' }}">
                        
                        <div class="absolute top-0 right-8 transform -translate-y-1/2 flex flex-col gap-1 items-end">
                            @if($package['badge'])
                                <span class="bg-amber-400 text-amber-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-sm">
                                    {{ $package['badge'] }}
                                </span>
                            @endif
                            
                           
                        </div>

                        <h3 class="text-xl font-bold mb-2 {{ $package['is_featured'] ? 'text-white' : 'text-slate-900' }}">
                            {{ $package['name'] }}
                        </h3>
                        <p class="text-sm mb-6 {{ $package['is_featured'] ? 'text-blue-100' : 'text-slate-500' }}">
                            {{ $package['description'] }}
                        </p>
                        
                        <div class="mb-6 {{ $package['is_featured'] ? 'text-white' : 'text-slate-900' }}">
                            <div class="flex items-center gap-2 mb-1">
                                @if(isset($package['original_price']) && $package['original_price'])
                                    <span class="text-sm line-through block opacity-60">
                                        {{ $package['original_price'] }}
                                    </span>
                                @endif

                                @if(isset($package['discount']) && $package['discount'])
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide shadow-sm">
                                        {{ $package['discount'] }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-4xl font-extrabold">{{ $package['price'] }}</span>
                            <span class="{{ $package['is_featured'] ? 'text-blue-200' : 'text-slate-500' }}">{{ $package['period'] }}</span>
                        </div>
                        
                        <ul class="space-y-4 mb-8 text-sm {{ $package['is_featured'] ? 'text-blue-50' : 'text-slate-600' }}">
                            @foreach ($package['features'] as $feature)
                                <li class="flex items-center {{ !$feature['available'] ? 'text-slate-400' : '' }}">
                                    @if($feature['available'])
                                        <svg class="w-5 h-5 mr-3 shrink-0 {{ $package['is_featured'] ? 'text-blue-200' : 'text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 mr-3 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    @endif
                                    {{ $feature['text'] }}
                                </li>
                            @endforeach
                        </ul>

                        <button class="w-full py-3 px-4 font-bold rounded-xl transition-colors shadow-sm {{ $package['is_featured'] ? 'bg-white text-blue-600 hover:bg-slate-50 hover:scale-105 transition-all duration-300' : ($package['price'] === 'Custom' ? 'bg-white text-slate-900 border-2 border-slate-200 hover:text-white hover:bg-blue-600 hover:scale-105 transition-all duration-300' : 'bg-white text-blue-600 border-2 hover:bg-blue-600 hover:text-white border-blue-100 hover:scale-105 transition-all duration-300') }}">
                            {{ $package['button_text'] }}
                        </button>
                        
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection