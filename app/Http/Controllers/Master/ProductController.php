<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            $data = [
                'nama' => $request->nama,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi ?? '-',
                'created_by' => auth()->user()->id
            ];
    
            Product::create($data);
    
            return back()->with('success', 'Berhasil!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = [
                'nama' => $request->nama,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi ?? '-',
                'updated_by' => auth()->user()->id
            ];
    
            Product::where('id', $id)->update($data);
    
            return back()->with('success', 'Berhasil!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = [
                'soft_delete' => 1,
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => auth()->user()->id
            ];
    
            Product::where('id', $id)->update($data);
    
            return back()->with('success', 'Berhasil!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
