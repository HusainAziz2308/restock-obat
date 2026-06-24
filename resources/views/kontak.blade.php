@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('page_title', 'Hubungi Tim Restock Obat')
@section('page_description', 'Punya pertanyaan mengenai paket Enterprise atau butuh bantuan teknis? Hubungi kami kapan saja.')

@section('content')
    @include('partials.page-header')

    <section class="py-24 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-100 border border-emerald-400 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in">
                    <svg class="w-6 h-6 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl p-8 md:p-12 border border-slate-200 shadow-sm">
                <form action="{{ route('kontak.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm @error('name') border-red-500 @enderror" placeholder="Contoh: Husain Aziz" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Bisnis / Apotek</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm @error('email') border-red-500 @enderror" placeholder="nama@apotek.com" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-slate-700 mb-2">Subjek Pesan</label>
                        <select name="subject" id="subject" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                            <option value="Demo Aplikasi Enterprise" {{ old('subject') == 'Demo Aplikasi Enterprise' ? 'selected' : '' }}>Permintaan Demo Paket Enterprise</option>
                            <option value="Pertanyaan Kemitraan / Harga" {{ old('subject') == 'Pertanyaan Kemitraan / Harga' ? 'selected' : '' }}>Pertanyaan Mengenai Harga Paket</option>
                            <option value="Kendala Teknis" {{ old('subject') == 'Kendala Teknis' ? 'selected' : '' }}>Kendala Teknis / Sistem</option>
                            <option value="Lainnya" {{ old('subject') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-slate-700 mb-2">Detail Pesan</label>
                        <textarea name="message" id="message" rows="6" 
                            class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm @error('message') border-red-500 @enderror" placeholder="Tuliskan detail kebutuhan atau pertanyaan Anda di sini..." required>{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            Kirim Pesan Sekarang
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </section>
@endsection