<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
        {
        $sliders = [
            [
                'image' => 'https://images.unsplash.com/photo-1586015555751-63bb77f4322a?q=80&w=1600&auto=format&fit=crop',
                'title' => 'Manajemen Inventaris Obat Modern',
                'subtitle' => 'Pantau ketersediaan stok dan kelola restock obat secara real-time dengan akurasi tinggi.'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=1600&auto=format&fit=crop',
                'title' => 'Terintegrasi dengan Supplier Utama',
                'subtitle' => 'Permudah jalur distribusi dan pemesanan obat langsung dari supplier terpercaya Anda.'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=1600&auto=format&fit=crop',
                'title' => 'Sistem Antarmuka Berbasis Cloud',
                'subtitle' => 'Akses dashboard manajemen apotek kapan saja dan di mana saja dengan aman.'
            ]
        ];

        return view('home', compact('sliders'));
    }
}
