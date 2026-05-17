@extends('layouts.app')

@section('title', 'Detail Profil - ' . substr($mahasiswa['nama'], 0, 12))

@section('page_title', 'Detail Profil - ' . substr($mahasiswa['nama'], 0, 12))
@section('page_description', 'Mengenal lebih dekat pengembang di balik sistem Restock Obat beserta kontribusi dan keahlian teknisnya.')

@section('content')
<div>
    @include('partials.page-header')

    <div class="bg-slate-50 min-h-screen py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ url('/about') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Tim
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden md:flex min-h-[480px]">

                <div class="md:w-1/4 bg-slate-900 relative min-h-[350px] md:min-h-auto flex items-stretch">
                    <div class="w-full h-full relative flex-1">
                        @if($mahasiswa['foto'] && file_exists(public_path('images/team/' . $mahasiswa['foto'])))
                            <img src="{{ asset('images/team/' . $mahasiswa['foto']) }}" alt="{{ $mahasiswa['nama'] }}" class="w-full h-full object-cover object-center absolute inset-0">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa['nama']) }}&background=020617&color=fff&size=512&bold=true" alt="{{ $mahasiswa['nama'] }}" class="w-full h-full object-cover absolute inset-0">
                        @endif

                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-slate-950/80 to-transparent z-10"></div>
                    </div>

                    <div class="absolute bottom-4 inset-x-0 flex justify-center z-20">
                        <div class="bg-blue-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg tracking-wider backdrop-blur-sm bg-opacity-90 hover:bg-white hover:text-blue-600 hover:scale-110 transition-all duration-200">
                            NIM: {{ $mahasiswa['nim'] }}
                        </div>
                    </div>
                </div>

                <div class="p-10 md:w-3/4 flex flex-col justify-between bg-white z-10">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight mb-2">
                            {{ $mahasiswa['nama'] }}
                        </h2>
                        <p class="text-blue-600 font-bold text-sm uppercase tracking-wider mb-6">
                            {{ $mahasiswa['program_studi'] }} - Semester {{ $mahasiswa['semester'] }}
                        </p>

                        <hr class="border-slate-100 mb-6">

                        <div class="space-y-6">
                            <div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Jabatan</span>
                                <p class="text-slate-700 font-medium text-base hover:text-blue-600 transition-all duration-300">{{ $mahasiswa['jabatan'] }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Status Akademik</span>
                                <p class="text-slate-700 font-medium text-base hover:text-blue-600 transition-all duration-300">{{ $mahasiswa['status'] }}</p>
                            </div>

                            <div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Spesialisasi / Keahlian</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($mahasiswa['keahlian'] as $skill)
                                    <span class="bg-blue-50 text-blue-600 text-xs font-semibold px-3.5 py-2 rounded-lg border border-blue-100 shadow-sm hover:bg-blue-600 hover:text-blue-50 hover:scale-105 transition-all duration-200">
                                        {{ $skill }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span class="font-medium">Universitas Pesantren Tinggi Darul 'Ulum</span>
                        <span class="font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">RESTOCK Developer</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
