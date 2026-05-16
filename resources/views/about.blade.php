@extends('layouts.app')

@section('title', 'Tentang Kami - Tim Developer')

@section('page_title', 'Meet Our Developer Team')
@section('page_description', 'Di balik platform Restock Obat, ada tim mahasiswa Sistem Informasi yang berdedikasi menciptakan arsitektur sistem manajemen inventaris terbaik.')

@section('content')
<div>
    @include('partials.page-header')

    <div class="bg-slate-50 min-h-screen py-16">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                @foreach ($mahasiswa as $mhs)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="relative h-64 bg-slate-900 overflow-hidden flex items-center justify-center">
                            @if($mhs['foto'] && file_exists(public_path('images/team/' . $mhs['foto'])))
                                <img src="{{ asset('images/team/' . $mhs['foto']) }}" alt="{{ $mhs['nama'] }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($mhs['nama']) }}&background=020617&color=fff&size=256&bold=true" alt="{{ $mhs['nama'] }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute bottom-3 left-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md hover:bg-white hover:text-blue-600 hover:scale-110 transition-all duration-200">
                                NIM: {{ $mhs['nim'] }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-1 tracking-tight hover:text-blue-600 transition-all">
                                <a href="{{ url('/about/' . $mhs['nim']) }}">{{ $mhs['nama'] }}</a>
                            </h3>
                            <p class="text-sm font-medium text-slate-500 mb-4">
                                {{ $mhs['program_studi'] }} - Semester {{ $mhs['semester'] }}
                            </p>
                            <div class="space-y-2">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">SKILL</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($mhs['keahlian'] as $skill)
                                    <span class="bg-blue-50 text-blue-600 text-xs font-medium px-2.5 py-1 rounded-md border border-blue-100 hover:bg-blue-600 hover:text-blue-50 transition-colors duration-200">
                                        {{ $skill }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-0 mt-4">
                        <a href="{{ url('/about/' . $mhs['nim']) }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-slate-200 text-sm font-semibold text-slate-700 bg-white hover:bg-blue-600 hover:text-white rounded-xl transition-all duration-200 gap-2 group">
                            Lihat Profil Detail
                        </a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
