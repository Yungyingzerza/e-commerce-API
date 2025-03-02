<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\UserAddress;

class Praemuay_Suaymakmak extends Seeder
{

    public function run(): void
    {
        User::create([
            'id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29',
            'name' => 'Praemuay',
            'surname' => 'Suaymakmak',
            'email' => 'Praemuay@gmail.com',
            'password' => '12345678',
            'balance' => 2400000,
            'level' => 5
        ]);

        UserAddress::create([
            'user_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29',
            'address' => 'Chiang Mai'
        ]);

        $Product = [
            ['id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29','category_id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'name' => 'SPEEDO Digital Placement Medalist One Piece Women\'s Swimsuit', 'description' => 'Fly through your fitness training wearing our graduated colour SPEEDO Digital Placement Medalist One Piece Women\'s Swimsuit. A Speedo favourite, our popular medalist style includes a medium neck and leg, plus a modest back for great shoulder movement and comfort during training. Light bust support via a comfy underband helps you feel secure and supported. Designed to be durable and better for the environment, the suit features our durable new ECO Endurance+ fabric which is 100% chlorine resistant, quick-drying and made from 50% recycled materials.', 'price' => 2590, 'stock' => 31],
            ['id' => '77e1dfc9-17d2-4029-8a1f-06d32eb4142d','category_id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'name' => 'WOMEN Swimsuit Lily Black', 'description' => 'Look and feel fabulous in the water. The flattering SPEEDO Lily women’s swimsuit provides more coverage than a swimsuit and includes an attractive wrap-effect neckline. The sporty mesh panelling and delicate strap detail add a modern, feminine touch while removable double bra pads add shape and offer extra modesty. The dress includes a fully integrated brief so you feel totally secure. Offering higher chlorine resistance than standard swimwear, our soft, stretchy Endurance10 fabric fits like new for longer with CREORA® HighClo™', 'price' => 3790, 'stock' => 17],
            ['id' => '28ff6b89-5070-4e75-8298-e8a47ce4d1c8','category_id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'name' => 'REEBOK ID Train Allover Print Women\'s Sports Bra', 'description' => 'Bring fresh energy to your workout with this REEBOK ID Train Allover Print Women\'s Sports Bra. Light support keeps you moving comfortably through Pilates and Barre class while sweat-wicking fabric keeps you dry. Mesh at the back delivers extra ventilation when the studio heats up, and a racerback silhouette provides a perfect fit.', 'price' => 1290, 'stock' => 15],
            ['id' => '8b291909-b652-4d3f-9fc7-7ca9edc889be','category_id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'name' => 'NIKE Pro Swoosh Asymmetrical Women\'s Sports Bra', 'description' => 'Pushing hard doesn\'t always go as expected—and this NIKE Pro Swoosh Asymmetrical Women\'s Sports Bra is ready for it. A bold jacquard strap adds visual interest, while medium support gives you a snug hold that helps keep everything in place. Super-stretchy fabric quickly recovers its shape and sewn-in padding offers stay-put coverage—so you can move your own way again and again.', 'price' => 1600, 'stock' => 24],
            ['id' => '17e31e9d-b6ec-4c7c-a5d9-8aa2923997eb','category_id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'name' => '9NINE N24GOSKW17 Women\'s Golf Skirt', 'description' => 'Crafted from a premium fabric, this 9NINE N24GOSKW17 Women\'s Golf Skirt offers exceptional comfort, flexibility, and breathability, ensuring you stay cool and comfortable throughout your round.', 'price' => 990, 'stock' => 21],
            ['id' => '9cdd383f-5a36-441a-a840-99a7a6db0e04','category_id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'name' => 'PUMA Downtown Cargo Midi Women\'s Skirt', 'description' => 'Enjoy the city in style. This PUMA Downtown Cargo Midi Women\'s Skirt keeps you comfortable yet chic with multiple pockets to stash your essentials. An elasticated waist and side slits offer a flattering, flexible fit for wherever the day takes you.', 'price' => 2800, 'stock' => 27],
        ];

        foreach ($Product as $product) {
            Product::create($product);
        }

        $product_image = [
            ['product_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'image_url' => 'https://assets.central.co.th/SPEEDO-WomenSwimsuitDigitalPlacementMedalistOnePiecePurpleSP111SP101DZTH-MKP1856255-1?$JPEG$&wid=550'],
            ['product_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'image_url' => 'https://assets.central.co.th/SPEEDO-WomenSwimsuitDigitalPlacementMedalistOnePiecePurpleSP111SP101DZTH-MKP1856255-2?$JPEG$&wid=550'],
            ['product_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'image_url' => 'https://assets.central.co.th/SPEEDO-WomenSwimsuitDigitalPlacementMedalistOnePiecePurpleSP111SP101DZTH-MKP1856255-3?$JPEG$&wid=550'],
            ['product_id' => 'd8eb8bc8-8653-4dff-b41a-d60c55af5c29', 'image_url' => 'https://assets.central.co.th/SPEEDO-WomenSwimsuitDigitalPlacementMedalistOnePiecePurpleSP111SP101DZTH-MKP1856255-4?$JPEG$&wid=550'],
            ['product_id' => '77e1dfc9-17d2-4029-8a1f-06d32eb4142d', 'image_url' => 'https://assets.central.co.th/SPEEDO-WomenSwimsuitLilyBlackSP111SP192CZTH-MKP1617546-1?$JPEG$&wid=550'],
            ['product_id' => '77e1dfc9-17d2-4029-8a1f-06d32eb4142d', 'image_url' => 'https://assets.central.co.th/SPEEDO-WomenSwimsuitLilyBlackSP111SP192CZTH-MKP1617546-5?$JPEG$&wid=550'],
            ['product_id' => '77e1dfc9-17d2-4029-8a1f-06d32eb4142d', 'image_url' => 'https://assets.central.co.th/SPEEDO-WomenSwimsuitLilyBlackSP111SP192CZTH-MKP1617546-6?$JPEG$&wid=550'],
            ['product_id' => '28ff6b89-5070-4e75-8298-e8a47ce4d1c8', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/RE099AP072DUTH-0.jpg?v=1734429785&width=1646'],
            ['product_id' => '28ff6b89-5070-4e75-8298-e8a47ce4d1c8', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/RE099AP072DUTH-1.jpg?v=1734429785&width=1646'],
            ['product_id' => '8b291909-b652-4d3f-9fc7-7ca9edc889be', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/NI083AP125EDTH-1.jpg?v=1737602676&width=1646'],
            ['product_id' => '8b291909-b652-4d3f-9fc7-7ca9edc889be', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/NI083AP125EDTH-2.jpg?v=1737602676&width=1646'],
            ['product_id' => '8b291909-b652-4d3f-9fc7-7ca9edc889be', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/NI083AP125EDTH-3.jpg?v=1737602676&width=1646'],
            ['product_id' => '17e31e9d-b6ec-4c7c-a5d9-8aa2923997eb', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/9N358AP371EFTH-0.jpg?v=1740562482&width=1646'],
            ['product_id' => '17e31e9d-b6ec-4c7c-a5d9-8aa2923997eb', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/9N358AP371EFTH-2.jpg?v=1740562482&width=1646'],
            ['product_id' => '17e31e9d-b6ec-4c7c-a5d9-8aa2923997eb', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/9N358AP371EFTH-4.jpg?v=1740562483&width=1646'],
            ['product_id' => '9cdd383f-5a36-441a-a840-99a7a6db0e04', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/PU097AP070DZTH-0.jpg?v=1734427745&width=1646'],
            ['product_id' => '9cdd383f-5a36-441a-a840-99a7a6db0e04', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/PU097AP070DZTH-1.jpg?v=1734427745&width=1646'],
            ['product_id' => '9cdd383f-5a36-441a-a840-99a7a6db0e04', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/PU097AP070DZTH-4.jpg?v=1734427745&width=1646'],
            
        ];

        foreach ($product_image as $image) {
            ProductImage::create($image);
        }



    }
}
