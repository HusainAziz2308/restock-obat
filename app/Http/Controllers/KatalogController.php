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
    public function edit($id)
    {
        $product = Medicine::findOrFail($id);
        return view('katalog.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Medicine::findOrFail($id);

        $product->update([
            'code' => $request->code,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'expired_date' => $request->expired_date,
            'image' => $request->image,
        ]);

        // jika upload gambar baru
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('images/obat'), $filename);

            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect('/katalog/' . $id);
    }
    public function create()
    {
        return view('katalog.create');
    }
}
