<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KatalogController extends Controller
{
    // DATA SEMENTARA (biar gak ditulis ulang terus)
    private $products = [
        ['id' => 1, 'nama' => 'Paracetamol', 'harga' => 3500],
        ['id' => 2, 'nama' => 'Amoxicillin', 'harga' => 6000],
        ['id' => 3, 'nama' => 'Ibuprofen', 'harga' => 4000],
        ['id' => 4, 'nama' => 'Salep Scabimite', 'harga' => 80000],
        ['id' => 5, 'nama' => 'Sanmol Syrup', 'harga' => 18000],
    ];

    // 📦 HALAMAN KATALOG
    public function index()
    {
        return view('produk.index', [
            'products' => $this->products
        ]);
    }

    // 📄 DETAIL PRODUK
    public function show($id)
    {
        $product = collect($this->products)->firstWhere('id', $id);

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // tambah deskripsi manual
        $product['deskripsi'] = match($id) {
            1 => 'Pereda demam & nyeri',
            2 => 'Antibiotik',
            3 => 'Anti-inflamasi',
            4 => 'Untuk luka ringan',
            5 => 'Sirup penurun panas',
            default => '-'
        };

        return view('produk.show', compact('product'));
    }

    // 🔍 SEARCH PRODUK
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $hasilCari = collect($this->products)->filter(function ($item) use ($keyword) {
            return str_contains(strtolower($item['nama']), strtolower($keyword));
        });

        return view('produk.search', [
            'products' => $hasilCari,
            'keyword' => $keyword
        ]);
    }

    // 🏷️ KATEGORI
    public function kategori($kategori)
    {
        return view('produk.kategori', [
            'kategori' => $kategori
        ]);
    }
}