<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class KatalogController extends Controller
{
    public function index()
    {
        $products = Medicine::all();
        return view('katalog.index', compact('products'));
    }

    public function show($id)
    {
        $product = Medicine::find($id);

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        return view('katalog.show', compact('product'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $products = Medicine::where('name', 'like', '%' . $keyword . '%')->get();

        return view('katalog.search', compact('products', 'keyword'));
    }

    public function kategori($kategori)
    {
        return view('produk.kategori', compact('kategori'));
    }
}
