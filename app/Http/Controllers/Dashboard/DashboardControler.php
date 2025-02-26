<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// ini_set('max_execution_time', 180);
class DashboardControler extends Controller
{
    public function index(Request $request)
    {
        $tgl_awal = !empty($request->tgl_awal) ? $request->tgl_awal : date('Y-m-01');
        $tgl_akhir = !empty($request->tgl_akhir) ? $request->tgl_akhir : date('Y-m-d');

        $sales_data = DB::table('sales')
            ->join('products', 'sales.products_id', '=', 'products.id')
            ->join('sales_people', 'sales.sales_person_id', '=', 'sales_people.id')
            ->where('products.soft_delete', 0)
            ->whereBetween('sales.tanggal_transaksi', [$tgl_awal, $tgl_akhir])
            ->select(
                'sales.sales_person_id',
                'sales.products_id',
                'sales_people.nama as sales_person_name',
                'products.nama as product_name',
                DB::raw('SUM(sales.sales_amount) as total_sales')
            )
            ->groupBy('sales.sales_person_id', 'sales.products_id', 'sales_people.nama', 'products.nama')
            ->paginate(10);

        $formatted_sales = [];
        foreach ($sales_data as $sale) {
            $formatted_sales[$sale->sales_person_id][$sale->products_id] = $sale->total_sales;
        }

        $sales_persons = DB::table('sales_people')->get();

        $produk = DB::table('products')->where('soft_delete', 0)->get();

        $set = [
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'formatted_sales' => $formatted_sales,
            'sales_data' => $sales_data,
            'sales_persons' => $sales_persons,
            'produk' => $produk,
        ];

        return view('dashboard.index', $set);
    }
}
