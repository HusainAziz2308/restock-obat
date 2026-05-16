@extends('layouts.app')

@section('title', 'Detail Profil - ' . $mahasiswa['nama'])

@section('page_title', 'Profil Anggota Tim')
@section('page_description', 'Mengenal lebih dekat pengembang di balik sistem Restock Obat beserta kontribusi dan keahlian teknisnya.')

@section('content')
<div class="pt-24 bg-slate-50 min-h-screen pb-24">
    @include('partials.page-header')
    <div class="max-w mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        
        <div class="mb-6">
            <a href="{{ url('/about') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors group">
                <svg class="w-5 h-5 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Tim
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden grid grid-cols-1 md:grid-cols-3">
            
            <div class="bg-slate-900 relative flex items-center justify-center h-80 md:h-full min-h-[320px]">
                @if($mahasiswa['foto'] && file_exists(public_path('images/team/' . $mahasiswa['foto'])))
                    <img src="{{ asset('images/team/' . $mahasiswa['foto']) }}" alt="{{ $mahasiswa['nama'] }}" class="w-full h-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa['nama']) }}&background=020617&color=fff&size=500&bold=true" alt="{{ $mahasiswa['nama'] }}" class="w-full h-full object-cover">
                @endif
            </div>

            <div class="p-8 md:p-10 col-span-2 flex flex-col justify-between">
                <div>
                    <div class="border-b border-slate-100 pb-5 mb-6">
                        <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                            Core Developer
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
                            {{ $mahasiswa['nama'] }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            NIM: {{ $mahasiswa['nim'] }} • {{ $mahasiswa['program_studi'] }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span class="text-xs text-slate-400 font-medium block uppercase tracking-wider">Status</span>
                            <span class="text-sm font-bold text-slate-800">Mahasiswa Aktif</span>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span class="text-xs text-slate-400 font-medium block uppercase tracking-wider">Semester</span>
                            <span class="text-sm font-bold text-slate-800">Semester {{ $mahasiswa['semester'] }}</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">
                            Penguasaan Kompetensi
                        </h4>
                        
                        @foreach ($mahasiswa['keahlian'] as $skill)
                        <div class="space-y-1.5">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-700">{{ $skill }}</span>
                                <span class="text-blue-600">Advanced</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full transition-all duration-1000" style="width: 85%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-slate-100 text-xs text-slate-400 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Terverifikasi dalam struktur pengembang sistem Restock Obat.
                </div>

            </div>

        </div>
    </div>
</div>
@endsection