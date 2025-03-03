<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class categories extends Seeder
{
    
    public function run(): void
    {
        $Categories = [
            ['id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'name' => 'Clothing', 'description' => 'Gear up in style with high-performance, breathable sportswear. Move freely, train harder!'],
            ['id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'name' => 'Shoes', 'description' => 'Step up your game with lightweight, durable sport shoes—built for speed, comfort, and performance!'],
            ['id' => '3ee20250-405f-4c32-bd06-45d02689f5ed', 'name' => 'Equipment', 'description' => 'Power your performance with top-quality sports equipment—perfect for football, basketball, tennis and more!']
        ];

        foreach ($Categories as $category) {
            Category::create($category);
        }
    }
}
