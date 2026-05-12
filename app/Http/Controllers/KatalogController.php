<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Validation\Rule;

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

        $data = $request->validate([
            'code' => ['required', 'string', 'max:255', Rule::unique('medicines', 'code')->ignore($product->id)],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'expired_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:medicines,code'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'expired_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/obat'), $filename);
            $data['image'] = $filename;
        }

        $product = Medicine::create($data);

        return redirect()->route('katalog.show', $product->id);
    }
}
