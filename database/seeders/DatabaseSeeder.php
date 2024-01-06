<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder ile oluşturulacak kayıt sayısı
        $recordCount = 50;

        // Seeder işlemleri
        for ($i = 1; $i <= $recordCount; $i++) {
            DB::table('products')->insert([
                'title' => 'Product ' . $i,
                'description' => 'Description for Product ' . $i,
                'image' => 'image-url-for-product-' . $i,
                'price' => rand(10, 100),
                'stock' => rand(1,100000),
                'visibility' => 1,
                'tag' => 'Tag' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
