<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'fairus',
            'email' => 'fairus@gmail.com',
            'password' => bcrypt('fairus123'),
        ]);
        
        
        // member
        \App\Models\Member::create([
            'name' => 'Fairus Salimi',
            'email' => 'lTqgj@example.com',
            'phone' => '85327919191'
        ]);
        \App\Models\Member::create([
            'name' => 'Lionel Messi',
            'email' => 'messi@example.com',
            'phone' => '81293994545'
        ]);

        // product
        \App\Models\Product::create([
            'product_name' => 'Cardigan Laviola',
            'selling_price' => 20000,
            'sku' => 'KR001',
            'stock' => 100,
            'color' => 'Merah',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);

        \App\Models\Product::create([
            'product_name' => 'Cardigan Diamond',
            'selling_price' => 30000,
            'sku' => 'KR002',
            'stock' => 100,
            'color' => 'Hijau',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);

        \App\Models\Product::create([
            'product_name' => 'Knit Kancing',
            'selling_price' => 10000,
            'sku' => 'KR003',
            'stock' => 50,
            'color' => 'Hitam',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);
        \App\Models\Product::create([
            'product_name' => 'Hodie Zipper',
            'selling_price' => 50000,
            'sku' => 'KR004',
            'stock' => 50,
            'color' => 'Merah',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);

        \App\Models\Product::create([
            'product_name' => 'Cardigan Anak',
            'selling_price' => 25000,
            'sku' => 'KR005',
            'stock' => 100,
            'color' => 'Kuning',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);

        \App\Models\Product::create([
            'product_name' => 'Cardigan Batik',
            'selling_price' => 25000,
            'sku' => 'KR006',
            'stock' => 10,
            'color' => 'Kuning',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);

        \App\Models\Product::create([
            'product_name' => 'Cardigan Remaja',
            'selling_price' => 25000,
            'sku' => 'KR007',
            'stock' => 100,
            'color' => 'Kuning',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);
        \App\Models\Product::create([
            'product_name' => 'Topi Anak',
            'selling_price' => 10000,
            'sku' => 'KR008',
            'stock' => 100,
            'color' => 'Kuning',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);

        \App\Models\Product::create([
            'product_name' => 'Celana Anak',
            'selling_price' => 18000,
            'sku' => 'KR009',
            'stock' => 100,
            'color' => 'Kuning',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);

        \App\Models\Product::create([
            'product_name' => 'Blues Cardigan',
            'selling_price' => 34000,
            'sku' => 'KR0010',
            'stock' => 100,
            'color' => 'Kuning',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);
        \App\Models\Product::create([
            'product_name' => 'Cardigan Batik',
            'selling_price' => 25000,
            'sku' => 'KR011',
            'stock' => 0,
            'color' => 'Kuning',
            'image' => 'https://via.placeholder.com/640x480.png/0022ee?text=laboriosam',
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
