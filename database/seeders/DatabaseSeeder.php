<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesPerson;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'name' => 'Admin ' . $i,
                'email' => "admin$i@gmail.com",
                'password' => bcrypt('123123')
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            SalesPerson::create([
                'user_id' => $i,
                'nama' => 'Sales ' . $i,
                'no_hp' => '085123' . rand(10000, 99999),
                'alamat' => 'Alamat ' . $i,
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Product::create([
                'nama' => 'Product ' . $i,
                'harga' => 100000,
                'stok' => 100,
                'deskripsi' => 'Deskripsi ' . $i,
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            $product = Product::find(rand(1, 5));
            $qty = rand(1, 5);
            Sales::create([
                'product_id' => $product->id,
                'sales_person_id' => rand(1, 10),
                'tanggal_transaksi' => date('Y-m-d'),
                'sales_amount' => $product->harga * $qty,
                'qty' => $qty,
            ]);
        }
    }
}
