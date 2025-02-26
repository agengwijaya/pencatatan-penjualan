<?php

namespace App\Abstracts;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductAbstract
{
  protected static $table = 'products';

  public static function getProduct($id)
  {
    $dt = DB::table('products')->whereId($id);
    $dt = $dt->first();
    if (!$dt) {
      throw new Exception('Data not found');
    }
    return $dt;
  }

  public static function calculateTotal($price, $qty)
  {    
    $totalHarga = 0;
    $totalDiskon = 0;
    
    $subtotal = $price * $qty;
    $diskon = 0;

    if ($qty >= 10) {
        $diskon += 0.15; // Dapat Diskon 15% jika beli >= 10
    } elseif ($qty >= 5) {
        $diskon += 0.10; // Dapat Diskon 10% jika beli >= 5
    }

    if ($subtotal >= 500000) {
        $diskon += 0.05; // Dapat Tambahan Diskon 5% jika subtotal >= 500,000
    }

    $hargaSetelahDiskon = $subtotal * (1 - $diskon);
    $totalHarga += $hargaSetelahDiskon;
    $totalDiskon += $subtotal - $hargaSetelahDiskon;

    return (object) ["total" => $totalHarga, "diskon" => $totalDiskon];
  }

  public static function validateStok($id, $qty)
  {
    $product = self::getProduct($id);
    if ($qty > $product->stok) {
      throw new Exception("Tidak bisa melakukan transaksi karena qty melebihi stok!");
    }
  }

  public static function returnStok($id, $qty) {
    Product::where('id', $id)->update([
      'stok' => DB::raw('stok + ' . (int) $qty)
    ]);
  }

  public static function decreaseStok($id, $qty, $old_id = null, $old_qty = null)
  {
    if ($old_id !== null && $old_qty !== null) {
      if ($old_id != $id) {
        Product::where('id', $old_id)->update([
          'stok' => DB::raw('stok + ' . (int) $old_qty)
        ]);

        Product::where('id', $id)->update([
          'stok' => DB::raw('stok - ' . (int) $qty)
        ]);
      } else {
        $qty_difference = (int) $qty - (int) $old_qty;
        Product::where('id', $id)->update([
          'stok' => DB::raw('stok - ' . $qty_difference)
        ]);
      }
    } else {
      Product::where('id', $id)->update([
        'stok' => DB::raw('stok - ' . (int) $qty)
      ]);
    }
  }
}
