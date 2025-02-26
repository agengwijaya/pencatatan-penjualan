<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $produk = Product::where('soft_delete', 0)->get();

        $set = [
            'produk' => $produk
        ];

        return view('master.product.index', $set);
    }

    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi ?? '-',
            'created_by' => auth()->user()->id
        ];

        Product::create($data);

        return back();
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi ?? '-',
            'updated_by' => auth()->user()->id
        ];

        Product::where('id', $id)->update($data);

        return back();
    }

    public function destroy($id)
    {
        $data = [
            'soft_delete' => 1,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => auth()->user()->id
        ];

        Product::where('id', $id)->update($data);

        return back();
    }
}
