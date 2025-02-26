<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SalesPerson;
use App\Models\User;
use Illuminate\Http\Request;

class SalesPersonController extends Controller
{
    public function index()
    {
        $sales_person = SalesPerson::where('soft_delete', 0)->get();
        $user = User::get();

        $set = [
            'sales_person' => $sales_person,
            'user' => $user,
        ];

        return view('master.sales_person.index', $set);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|unique:sales_people,user_id',
            'nama' => 'required'
        ]);

        $data = [
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'provinsi_id' => $request->provinsi_id,
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'nama_provinsi' => $request->nama_provinsi,
            'nama_kabupaten' => $request->nama_kabupaten,
            'nama_kecamatan' => $request->nama_kecamatan,
            'nama_kelurahan' => $request->nama_kelurahan,
            'alamat' => $request->alamat ?? '-',
            'created_by' => auth()->user()->id
        ];

        SalesPerson::create($data);

        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|unique:sales_people,user_id,' . $id,
            'nama' => 'required'
        ]);

        $data = [
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'provinsi_id' => $request->provinsi_id,
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'nama_provinsi' => $request->nama_provinsi,
            'nama_kabupaten' => $request->nama_kabupaten,
            'nama_kecamatan' => $request->nama_kecamatan,
            'nama_kelurahan' => $request->nama_kelurahan,
            'alamat' => $request->alamat ?? '-',
            'updated_by' => auth()->user()->id
        ];

        SalesPerson::where('id', $id)->update($data);

        return back();
    }

    public function destroy($id)
    {
        $data = [
            'soft_delete' => 1,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => auth()->user()->id
        ];

        SalesPerson::where('id', $id)->update($data);

        return back();
    }
}
