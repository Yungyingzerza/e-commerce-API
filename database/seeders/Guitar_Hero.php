<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;

class Guitar_Hero extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Guitar',
            'surname' => 'Hero',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce'
        ]);

        $Product = [
            ['id' => '2ff97732-3b6b-4f78-96b9-98f8006e28db','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'Nike Air Mag', 'description' => 'The Air Mag gave us a real opportunity to see the futuristic technology and the opportunities Nike had in the \'80s, moving towards the new millennium,” said Robert Williams, senior brand creative sneaker culture and footwear curation. “The Air Mag explored design concepts and ideas that would be incorporated into future Nike products, such as HyperAdapt and Adapt technology. Its one-of-a-kind design mixed with technology sets the standard for collaboration.', 'price' => 1278375, 'stock' => 3],
        ];

        foreach ($Product as $product) {
            Product::create($product);
        }

        $product_image = [
            ['product_id' => '2ff97732-3b6b-4f78-96b9-98f8006e28db', 'image_url' => 'https://static.nike.com/a/images/f_auto/dpr_3.0,cs_srgb/w_363,c_limit/22c599f5-6ae3-43f7-afd2-fd904625ec03/from-the-archives-the-evolution-of-nike-air-mag.jpg'],
            ['product_id' => '2ff97732-3b6b-4f78-96b9-98f8006e28db', 'image_url' => 'https://image.goxip.com/Kx7El9QggFYszGgKpXgjbHrTBQ8=/fit-in/500x500/filters:format(jpg):quality(80):fill(white)/https:%2F%2Fcdn-images.farfetch-contents.com%2F14%2F16%2F46%2F74%2F14164674_21073031_1000.jpg'],
        ];

        foreach ($product_image as $image) {
            ProductImage::create($image);
        }
    }
}
