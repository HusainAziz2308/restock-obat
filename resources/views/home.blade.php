@extends('layouts.app')

@section('title', 'Selamat Datang di Restock Obat')

@section('content')
    @include('partials.slider')

    <section class="relative z-10 -mt-7 max-w-7xl mx-auto px-6 md:px-12">
        <div
            class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8 flex flex-col md:flex-row justify-around items-stretch gap-6 text-center hover:shadow-2xl transition-shadow duration-300">

            <div class="flex-1 space-y-1 py-2">
                <p class="text-3xl md:text-4xl font-extrabold text-blue-600 tracking-tight">99.9%</p>
                <p class="text-xs md:text-sm font-semibold text-slate-500">Stok Akurat & Real-time</p>
            </div>

            <div class="flex-1 border-slate-100 md:border-l space-y-1 py-2">
                <p class="text-3xl md:text-4xl font-extrabold text-blue-600 tracking-tight">24 Jam</p>
                <p class="text-xs md:text-sm font-semibold text-slate-500">Call Center</p>
            </div>

            <div class="flex-1 border-slate-100 md:border-l space-y-1 py-2">
                <p class="text-3xl md:text-4xl font-extrabold text-blue-600 tracking-tight">100%</p>
                <p class="text-xs md:text-sm font-semibold text-slate-500">Menu Lengkap</p>
            </div>

        </div>
    </section>

    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-blue-600 font-bold text-sm uppercase tracking-wider block mb-2">Keunggulan Platform</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                Kenapa Memilih Restock Obat?
            </h2>
            <p class="mt-4 text-base md:text-lg text-slate-500 max-w-2xl mx-auto">
                Kami mengintegrasikan manajemen inventaris apotek tradisional ke dalam ekosistem digital yang cepat, aman,
                dan transparan.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <div
                    class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-left flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Manajemen Stok Lengkap</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Menu lengkap dengan customisasi obat, kategori, dan informasi detail untuk memudahkan pencarian
                            dan management stok.
                        </p>
                    </div>
                </div>

                <div
                    class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-left flex flex-col justify-between">
                    <div>
                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Keamanan Sistem Terjamin</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Seluruh sistem kami dilengkapi dengan protokol keamanan tingkat tinggi, enkripsi data, dan
                            backup rutin untuk melindungi informasi sensitif Anda.
                        </p>
                    </div>
                </div>

                <div
                    class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-left flex flex-col justify-between">
                    <div>
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Fitur Upload Resep</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Upload resep dokter secara digital untuk memudahkan proses restock obat berdasarkan kebutuhan
                            aktual pasien, dengan validasi otomatis untuk memastikan keakuratan data.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-50 border-t border-b border-slate-100">
        <div class="max-w-full mx-auto px-6 md:px-12">

            <div class="text-center mb-20">
                <span class="text-blue-600 font-bold text-sm uppercase tracking-wider block mb-2">Alur Kerja Sistem</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Bagaimana Restock Obat Mengelola Gudang Anda?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">

                <div
                    class="hidden md:block absolute top-8 left-[16%] right-[16%] h-0.5 border-t-2 border-dashed border-slate-200 z-0">
                </div>

                <div class="text-center relative group z-10">
                    <div
                        class="w-16 h-16 rounded-full bg-white shadow-md text-blue-600 font-extrabold text-xl flex items-center justify-center mx-auto mb-6 border border-slate-100 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
                        1
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">
                        Pencatatan & Inbound Stok
                    </h4>
                    <p class="text-slate-500 text-sm max-w-xs mx-auto leading-relaxed">
                        Mendata pasokan obat masuk dari <b>Suppliers</b>. Sistem otomatis merekam data berdasarkan satuan
                        (<b>Units</b>), pengelompokan jenis (<b>Categories</b>), serta melacak <b>Expired Date</b> secara digital.
                    </p>
                </div>

                <div class="text-center relative group z-10">
                    <div
                        class="w-16 h-16 rounded-full bg-white shadow-md text-blue-600 font-extrabold text-xl flex items-center justify-center mx-auto mb-6 border border-slate-100 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
                        2
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">
                        Monitoring Threshold & Opname
                    </h4>
                    <p class="text-slate-500 text-sm max-w-xs mx-auto leading-relaxed">
                        Aplikasi memantau <b>Current Stock</b> secara real-time. Jika kuantitas fisik obat menyentuh ambang
                        batas minimum (<b>Min Stock Level</b>), sistem akan otomatis memicu status pengadaan ulang (<b>Restock</b>).
                    </p>
                </div>

                <div class="text-center relative group z-10">
                    <div
                        class="w-16 h-16 rounded-full bg-white shadow-md text-blue-600 font-extrabold text-xl flex items-center justify-center mx-auto mb-6 border border-slate-100 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
                        3
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">
                        Verifikasi Resep & Outbound
                    </h4>
                    <p class="text-slate-500 text-sm max-w-xs mx-auto leading-relaxed">
                        Memproses <b>Transactions</b> keluar via validasi digital dokumen <b>Prescriptions</b> (unggah berkas
                        resep). Otomatis memperbarui <b>Transaction Details</b> dan memotong sisa stok gudang dengan aman.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-r from-slate-900 to-blue-950 rounded-3xl p-10 md:p-16 text-center relative overflow-hidden shadow-2xl">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-purple-600 rounded-full blur-3xl opacity-20"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <h3 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-4">
                        Siap Mempermudah Manajemen Inventaris Apotek Anda?
                    </h3>
                    <p class="text-slate-300 text-sm md:text-base mb-8 leading-relaxed">
                        Bergabunglah bersama ratusan jaringan penyedia fasilitas kesehatan dan rasakan kemudahan distribusi
                        obat digital yang cepat, transparan, dan terstruktur.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="/katalog"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 hover:scale-105 transition-all text-white font-semibold rounded-xl shadow-lg  duration-200">
                            Jelajahi Katalog
                        </a>
                        <a href="/contact"
                            class="px-6 py-3 bg-slate-800 hover:bg-slate-700 hover:scale-105 text-white font-semibold rounded-xl border border-slate-700 transition-all duration-200">
                            Hubungi Tim Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
