<?php

namespace App\Http\Controllers\Sales;

use App\Abstracts\ProductAbstract;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesPerson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $product = Product::where('soft_delete', 0)->get();
        $sales_person = SalesPerson::where('soft_delete', 0)->get();

        $set = [
            'product' => $product,
            'sales_person' => $sales_person,
        ];

        return view('master.sales.index', $set);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $pageNumber = ($request->start / $request->length) + 1;
            $pageLength = $request->length;
            $skip       = ($pageNumber - 1) * $pageLength;

            $orderColumnIndex = $request->order[0]['column'] ?? '0';
            $orderBy = $request->order[0]['dir'] ?? 'desc';

            $query = DB::table('sales as a')
                ->leftJoin('sales_persons as b', 'b.id', 'a.sales_person_id')
                ->leftJoin('products as c', 'c.id', 'a.product_id')
                ->where('a.soft_delete', 0)
                ->select(
                    'a.id',
                    'a.sales_person_id',
                    'a.product_id',
                    'a.tanggal_transaksi',
                    'c.harga',
                    'a.qty',
                    'a.sub_total',
                    'a.diskon',
                    'a.sales_amount',
                    'b.nama as sales',
                    'c.nama as product',
                );

            $search = $request->search;
            $query = $query->where(function ($query) use ($search) {
                $query->orWhere('a.tanggal_transaksi', 'like', "%" . $search . "%");
                $query->orWhere('b.nama', 'like', "%" . $search . "%");
                $query->orWhere('c.nama', 'like', "%" . $search . "%");
                $query->orWhere('a.sales_amount', 'like', "%" . $search . "%");
                $query->orWhere('a.qty', 'like', "%" . $search . "%");
                $query->orWhere('a.sub_total', 'like', "%" . $search . "%");
                $query->orWhere('a.diskon', 'like', "%" . $search . "%");
                $query->orWhere('c.harga', 'like', "%" . $search . "%");
            });

            $orderByName = 'tanggal_transaksi';
            switch ($orderColumnIndex) {
                case '0':
                    $orderByName = 'tanggal_transaksi';
                    break;
                case '1':
                    $orderByName = 'nama';
                    break;
            }

            $query = $query->orderBy($orderByName, $orderBy);
            $recordsFiltered = $recordsTotal = $query->count();
            $result = $query->skip($skip)->take($pageLength)->get();
            $data = [];

            foreach ($result as $key => $value) {
                $data[] = $value;

                $aksi = '';
                $aksi .= "<button class='btn btn-danger btn-xs' id='btn_delete' data-bs-target='#modalDeleteConfirm' data-bs-toggle='modal' data-id='" . $value->id . "'><i class='fa fa-trash'></i></button>";
                $aksi .= "<button class='btn btn-warning btn-xs' id='btn_edit' data-bs-target='#modalEdit' data-bs-toggle='modal' data-data='" . json_encode($value) . "'><i class='fa fa-pencil'></i></button>";

                $data[$key]->aksi = $aksi;
            }

            return response()->json(["draw" => $request->draw, "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $data], 200);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($request->product_id);

            ProductAbstract::validateStok($request->product_id, $request->qty);

            ProductAbstract::decreaseStok($request->product_id, $request->qty);

            $calculate = ProductAbstract::calculateTotal($product->harga, $request->qty);

            $data = [
                'product_id' => $request->product_id,
                'sales_person_id' => $request->sales_person_id,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'qty' => $request->qty,
                'sub_total' => $request->qty * $product->harga,
                'diskon' => $calculate->diskon,
                'sales_amount' => $calculate->total,
                'created_by' => auth()->user()->id
            ];

            Sales::create($data);
            DB::commit();
    
            return back()->with('success', 'Berhasil!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {    
        try {
            DB::beginTransaction();
            $product = Product::find($request->product_id);
            $sales = Sales::findOrFail($id);
            $old_product_id = $sales->product_id;
            $old_qty = $sales->qty;
    
            ProductAbstract::validateStok($request->product_id, $request->qty);
        
            $new_product_id = $request->product_id;
            $new_qty = $request->qty;

            ProductAbstract::decreaseStok($new_product_id, $new_qty, $old_product_id, $old_qty);
            $calculate = ProductAbstract::calculateTotal($product->harga, $request->qty);
    
            $data = [
                'product_id' => $request->product_id,
                'sales_person_id' => $request->sales_person_id,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'qty' => $request->qty,
                'sub_total' => $request->qty * $product->harga,
                'diskon' => $calculate->diskon,
                'sales_amount' => $calculate->total,
                'updated_by' => auth()->user()->id
            ];
    
            Sales::where('id', $id)->update($data);
            DB::commit();
    
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
    
            $sales = Sales::find($id);
    
            DB::beginTransaction();
            ProductAbstract::returnStok($sales->product_id, $sales->qty);
    
            Sales::where('id', $id)->update($data);
            DB::commit();
    
            return back()->with('success', 'Berhasil!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
