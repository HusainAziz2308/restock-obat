<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        $rawPackages = [
            [
                'name' => 'Apotek Starter',
                'description' => 'Cocok untuk apotek retail atau klinik skala kecil.',
                'original_price' => 199000,
                'discount_percent' => 0, // %
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
                'original_price' => 499000,
                'discount_percent' => 20, // %
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
                'original_price' => 'Custom',
                'discount_percent' => 0,
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

        $packages = [];
        foreach ($rawPackages as $package) {
            if (is_string($package['original_price']) && !is_numeric($package['original_price'])) {
                $package['price'] = $package['original_price'];
                $package['original_price'] = null;
                $package['discount'] = null;
            } elseif ($package['discount_percent'] > 0) {
                $discountAmount = ($package['original_price'] * $package['discount_percent']) / 100;
                $finalPrice = $package['original_price'] - $discountAmount;

                $package['price'] = 'Rp ' . ($finalPrice / 1000) . 'k';
                $package['original_price'] = 'Rp ' . ($package['original_price'] / 1000) . 'k';
                $package['discount'] = 'Diskon ' . $package['discount_percent'] . '%';
            } else {
                $package['price'] = 'Rp ' . ($package['original_price'] / 1000) . 'k';
                $package['original_price'] = null;
                $package['discount'] = null;
            }
            $packages[] = $package;
        }
        return view('katalog', compact('packages'));
    }
}
