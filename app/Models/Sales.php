<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function sales_person()
    {
        return $this->belongsTo(SalesPerson::class);
    }
}
