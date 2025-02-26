<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPerson extends User
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'nama',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'nama_provinsi',
        'nama_kabupaten',
        'nama_kecamatan',
        'nama_kelurahan',
        'alamat',
        'no_hp',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'soft_delete',
    ];

    public function sales()
    {
        return $this->hasMany(Sales::class, 'sales_person_id');
    }
}
