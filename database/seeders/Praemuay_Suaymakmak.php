<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class Praemuay_Suaymakmak extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Praemuay',
            'surname' => 'Suaymakmak',
            'email' => 'Praemuay@gmail.com',
            'password' => '12345678',
            'id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29'
        ]);

        $Product = [
            ['category_id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'name' => 'T-shirt', 'description' => 'Gear up in style with high-performance, breathable sportswear. Move freely, train harder!', 'price' => 100, 'stock' => 10],
        ];

        foreach ($Product as $product) {
            Product::create($product);
        }



    }
}
