<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        $packages = [
            [
                'name' => 'Apotek Starter',
                'description' => 'Cocok untuk apotek retail atau klinik skala kecil.',
                'price' => 'Rp 199k',
                'period' => '/bulan',
                'is_featured' => false,
                'badge' => null,
                'button_text' => 'Mulai 7 Hari Gratis!!!',
                'features' => [
                    ['text' => 'Management Stok Inbound & Outbound', 'available' => true],
                    ['text' => 'Maksimal 1,000 SKU Obat', 'available' => true],
                    ['text' => 'Sistem FEFO/FIFO Dasar', 'available' => true],
                    ['text' => 'Fitur Multi-Gudang', 'available' => false],
                ]
            ],
            [
                'name' => 'Gudang Pro',
                'description' => 'Ideal untuk distributor dan jaringan faskes menengah.',
                'price' => 'Rp 499k',
                'period' => '/bulan',
                'is_featured' => true,
                'badge' => 'Paling Laris',
                'button_text' => 'Pilih Paket Pro',
                'features' => [
                    ['text' => 'Semua Fitur Starter', 'available' => true],
                    ['text' => 'Unlimited SKU Obat', 'available' => true],
                    ['text' => 'Validasi Resep Digital', 'available' => true],
                    ['text' => 'Notifikasi Otomatis Min. Stock Level', 'available' => true],
                ]
            ],
            [
                'name' => 'RS Enterprise',
                'description' => 'Skala besar untuk Rumah Sakit & Farmasi Nasional.',
                'price' => 'Custom',
                'period' => '',
                'is_featured' => false,
                'badge' => null,
                'button_text' => 'Hubungi Sales',
                'features' => [
                    ['text' => 'Semua Fitur Gudang Pro', 'available' => true],
                    ['text' => 'Manajemen Multi-Gudang', 'available' => true],
                    ['text' => 'API Integration', 'available' => true],
                    ['text' => 'Support Prioritas 24/7', 'available' => true],
                ]
            ]
        ];
        return view('katalog', compact('packages'));
    }
}