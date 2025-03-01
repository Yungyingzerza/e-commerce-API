<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;

class Guitar_Hero extends Seeder
{

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
            //['id' => '2ff97732-3b6b-4f78-96b9-98f8006e28db','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'Nike Air Mag', 'description' => 'The Air Mag gave us a real opportunity to see the futuristic technology and the opportunities Nike had in the \'80s, moving towards the new millennium,” said Robert Williams, senior brand creative sneaker culture and footwear curation. “The Air Mag explored design concepts and ideas that would be incorporated into future Nike products, such as HyperAdapt and Adapt technology. Its one-of-a-kind design mixed with technology sets the standard for collaboration.', 'price' => 1278375, 'stock' => 3],
            ['id' => '13c9fceb-f6c9-4d1b-9ee0-ff1693443645','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'Nike Vomero 18', 'description' => 'Maximum cushioning in the Vomero provides a comfortable ride for everyday runs. Our softest, most cushioned ride has lightweight ZoomX foam stacked on top of responsive ReactX foam in the midsole. Plus, a redesigned traction pattern offers a smooth heel-to-toe transition.', 'price' => 5500, 'stock' => 123],
            ['id' => 'd6b38f32-481d-42ae-891f-8e9a791b992e','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'Nike Cortez', 'description' => 'One word: tradition. From track superstar to fashion phenom, the Cortez\'s Retro appeal, sponge-soft midsole and seesaw detailing deliver decade after decade. This iteration combines genuine leather and heart details for a design that\'s destined to be love at first sight.', 'price' => 3600, 'stock' => 34],
            ['id' => 'b5820f4e-c608-4b56-ba3b-50bd3f18b429','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'CROCS Baya Clog', 'description' => 'CROCS Baya Clog casual shoes with a twist on the brand\'s signature Classic Clog, feature the lightweight, durable build you love with advanced ventilation for breathability and to help drain water and debris.', 'price' => 2190, 'stock' => 42],
            ['id' => '44d0dd78-1aea-4162-9de5-e7a470ec717b','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'CROCS Classic Clog', 'description' => 'The CROCS Classic Clog unisex casual shoes with a perforated upper are manufactured from foam, featuring Croslite ™ and Iconic Crocs Comfort ™ technologies that provide lightweight, flexibility and foot support while wearing.', 'price' => 2190, 'stock' => 31],
            ['id' => '2451d05e-6d22-4b0d-8f88-8460eb12bcd8','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'ADIDAS Switch Fwd 2', 'description' => 'These ADIDAS Switch Fwd 2 Men\'s Running Shoes turn gravity into forward motion to make every run feel easier. How? With purpose-built voids in the outsole that compress and expand to create momentum with every stride. A durable textile upper holds up across the kilometres and the Continental™ Rubber outsole delivers grip in all conditions.', 'price' => 3180, 'stock' => 29],
            ['id' => '4203c178-2fcb-4337-85e2-862279fe268e','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'ADIDAS Supernova Stride', 'description' => 'We\'ve designed the ADIDAS Supernova Stride Women\'s Running Shoes to equip runners with the comfort, support, and fit for their everyday runs. Dreamstrike+ super foam is our re-engineered super foam, purposefully placed in the forefoot for a supportive push-off and maximum comfort. To complete the comfortable midsole, we\'ve added a supportive Carrier EVA to make sure your transitions are both dynamic and supportive. With Supernova Stride, get ready to run with confidence thanks to an Adiwear Outsole made of durable rubber to provide optimal traction where runners need it most.', 'price' => 2160, 'stock' => 14],
            ['id' => 'e75a26cb-3b52-4d83-9a62-af3108effc28','category_id' => '2ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'ADIDAS Switch Move', 'description' => 'The easier your run feels, the farther you can go. These ADIDAS Switch Move Women\'s Running Shoes your stride with a lightweight EVA midsole. They\'re designed to deliver a smooth ride that enhances forward momentum so that every kilometre feels as good as the one before. The comfy mesh upper rides on an Adiwear outsole for optimum durability and grip.', 'price' => 2000, 'stock' => 56],
            ['id' => '37bf2fa4-35b3-454a-b1cb-8e9850a17f48','category_id' => '3ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'YONEX GR Alpha (2 Pack) Badminton Racket', 'description' => 'YONEX Racket GR Alpha- Hit powerful shots and improves your badminton skills by bringing home this excellent racket, brought to you by Yonex.', 'price' => 590, 'stock' => 45],
            ['id' => '9aa56240-194f-4eef-ab3e-945823f734d2','category_id' => '3ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'WILSON Minions Clash 100L V2 Tennis Racket', 'description' => '2023 WILSON x MINIONS collaboration design WILSON Minions Clash 100L V2 Tennis Racket that bends more than a wood racket and exhibits high stability. By updating the carbon layup at the top of the frame, the V2.0 expands the sweet area upwards compared to the previous model while maintaining the original bending of the CLASH, improving power transfer to the ball.', 'price' => 11500, 'stock' => 12],
            ['id' => 'bd874b02-adc6-43f1-bd44-bb4c80ad1191','category_id' => '3ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'S SPORTS 3 Star 02 Table Tennis Set', 'description' => 'Shop the S SPORTS 3 Star 02 Table Tennis Set at Guitar Hero now!!', 'price' => 329, 'stock' => 25],
            ['id' => '08e5a8bc-a14a-4390-ae47-a300b8da2937','category_id' => '3ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'WILSON NBA DRV Basketball Ball', 'description' => 'Inspired by the drive that lives inside every NBA hopeful. The WILSON NBA DRV Basketball Ball is designed for outdoor play for all players and is built to stand up to the elements. Inflation Retention Lining creates longer-lasting air retention with this ball designed for ultimate outdoor durability.', 'price' => 690, 'stock' => 30],
            ['id' => 'e0ab2934-83f3-48d5-8aae-be4108de71cd','category_id' => '3ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'NIKE Premier League Pitch Football Ball', 'description' => 'Made for your intense training sessions and enhancing your footwork, the NIKE Premier League Pitch Football Ball is made to help you level up your game. Its 12-panel design and durable casing help maintain true shape and durability, training session after training session.', 'price' => 850, 'stock' => 7],
            ['id' => '7828a012-f558-4b12-bf78-ab8d26b8b63b','category_id' => '1ee20250-405f-4c32-bd06-45d02689f5ed', 'user_id' => '47a91dfd-4fee-4b99-ae86-dcd0842f50ce', 'name' => 'NIKE Men\'s Liverpool FC Home Stadium 2024/25 Jersey', 'description' => 'Our NIKE Men\'s Liverpool FC Home Stadium 2024/25 Jersey pairs replica design details with sweat-wicking technology to give you a game-ready look inspired by your favorite team.', 'price' => 2900, 'stock' => 20],
        ];

        foreach ($Product as $product) {
            Product::create($product);
        }

        $product_image = [
            ['product_id' => '2ff97732-3b6b-4f78-96b9-98f8006e28db', 'image_url' => 'https://static.nike.com/a/images/f_auto/dpr_3.0,cs_srgb/w_363,c_limit/22c599f5-6ae3-43f7-afd2-fd904625ec03/from-the-archives-the-evolution-of-nike-air-mag.jpg'],
            ['product_id' => '2ff97732-3b6b-4f78-96b9-98f8006e28db', 'image_url' => 'https://image.goxip.com/Kx7El9QggFYszGgKpXgjbHrTBQ8=/fit-in/500x500/filters:format(jpg):quality(80):fill(white)/https:%2F%2Fcdn-images.farfetch-contents.com%2F14%2F16%2F46%2F74%2F14164674_21073031_1000.jpg'],
            ['product_id' => '13c9fceb-f6c9-4d1b-9ee0-ff1693443645', 'image_url' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/1983f2e1-0271-479c-bada-6176a571fa4f/NIKE+VOMERO+18.png'],
            ['product_id' => '13c9fceb-f6c9-4d1b-9ee0-ff1693443645', 'image_url' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/df49b282-4ff7-42fd-9388-d5478e951041/NIKE+VOMERO+18.png'],
            ['product_id' => '13c9fceb-f6c9-4d1b-9ee0-ff1693443645', 'image_url' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/2946648c-e96e-490a-a1e8-284c2a5fa653/NIKE+VOMERO+18.png'],
            ['product_id' => 'd6b38f32-481d-42ae-891f-8e9a791b992e', 'image_url' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/c7ef8fe0-cdbd-4033-b613-debf06a95aa7/W+NIKE+CORTEZ.png'],
            ['product_id' => 'd6b38f32-481d-42ae-891f-8e9a791b992e', 'image_url' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/a7b498d5-0841-4753-a9bf-13a888f156ae/W+NIKE+CORTEZ.png'],
            ['product_id' => 'b5820f4e-c608-4b56-ba3b-50bd3f18b429', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/CR024SH056CFTH-0.jpg?v=1738815717&width=1646'],
            ['product_id' => 'b5820f4e-c608-4b56-ba3b-50bd3f18b429', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/CR024SH056CFTH-1.jpg?v=1738053603&width=1646'],
            ['product_id' => 'b5820f4e-c608-4b56-ba3b-50bd3f18b429', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/CR024SH056CFTH-4.jpg?v=1738053603&width=1646'],
            ['product_id' => '44d0dd78-1aea-4162-9de5-e7a470ec717b', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/CR024SH048CTTH-0.jpg?v=1738815344&width=1646'],
            ['product_id' => '44d0dd78-1aea-4162-9de5-e7a470ec717b', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/CR024SH048CTTH-2.jpg?v=1738053545&width=1646'],
            ['product_id' => '44d0dd78-1aea-4162-9de5-e7a470ec717b', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/CR024SH048CTTH-4.jpg?v=1738053545&width=1646'],
            ['product_id' => '2451d05e-6d22-4b0d-8f88-8460eb12bcd8', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH549ECTH-0.jpg?v=1739337256&width=1646'],
            ['product_id' => '2451d05e-6d22-4b0d-8f88-8460eb12bcd8', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH549ECTH-2.jpg?v=1737975901&width=1646'],
            ['product_id' => '2451d05e-6d22-4b0d-8f88-8460eb12bcd8', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH549ECTH-5.jpg?v=1734408126&width=1646'],
            ['product_id' => '4203c178-2fcb-4337-85e2-862279fe268e', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH816DZTH-0.jpg?v=1739338588&width=1646'],
            ['product_id' => '4203c178-2fcb-4337-85e2-862279fe268e', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH816DZTH-2.jpg?v=1734409266&width=1646'],
            ['product_id' => '4203c178-2fcb-4337-85e2-862279fe268e', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH816DZTH-4.jpg?v=1734409266&width=1646'],
            ['product_id' => 'e75a26cb-3b52-4d83-9a62-af3108effc28', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH439EBTH-0.jpg?v=1739337442&width=1646'],
            ['product_id' => 'e75a26cb-3b52-4d83-9a62-af3108effc28', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH439EBTH-1.jpg?v=1734407645&width=1646'],
            ['product_id' => 'e75a26cb-3b52-4d83-9a62-af3108effc28', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/AD001SH439EBTH-4.jpg?v=1734407645&width=1646'],
            ['product_id' => '37bf2fa4-35b3-454a-b1cb-8e9850a17f48', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/YO136SP015GCTH-0.jpg?v=1736925798&width=1646'],
            ['product_id' => '9aa56240-194f-4eef-ab3e-945823f734d2', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/WI134SP225DFTH-0.jpg?v=1734444124&width=1646'],
            ['product_id' => 'bd874b02-adc6-43f1-bd44-bb4c80ad1191', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/SB146SP690DUTH-0.jpg?v=1734433385&width=1646'],
            ['product_id' => 'bd874b02-adc6-43f1-bd44-bb4c80ad1191', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/SB146SP690DUTH-1.jpg?v=1734433385&width=1646'],
            ['product_id' => '08e5a8bc-a14a-4390-ae47-a300b8da2937', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/WI134AC132DKTH-0.jpg?v=1734443884&width=1646'],
            ['product_id' => 'e0ab2934-83f3-48d5-8aae-be4108de71cd', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/NI083AC248DWTH-0.jpg?v=1734403564&width=1646'],
            ['product_id' => '7828a012-f558-4b12-bf78-ab8d26b8b63b', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/NI083AP458DWTH-2.jpg?v=1734419766&width=1646'],
            ['product_id' => '7828a012-f558-4b12-bf78-ab8d26b8b63b', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/NI083AP458DWTH-3.jpg?v=1734419766&width=1646'],
            ['product_id' => '7828a012-f558-4b12-bf78-ab8d26b8b63b', 'image_url' => 'https://www.supersports.co.th/cdn/shop/files/NI083AP458DWTH-4.jpg?v=1734419766&width=1646'],
        ];

        foreach ($product_image as $image) {
            ProductImage::create($image);
        }
    }
}
