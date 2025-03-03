<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Product;
use App\Models\Comments;
use App\Models\Wishlists;
use Database\Seeders\Guitar_Hero;

class Tanapol_Wattanasuk extends Seeder
{

    public function run(): void
    {
        User::create([
            'id' => '32d28339-0967-4548-bc44-fc590c2005a9',
            'name' => 'Tanapol',
            'surname' => 'Wattanasuk',
            'email' => 'imguitar99@gmail.com',
            'password' => '@Isametric132547',
            'balance' => 1500,
            'level' => 1
        ]);

        UserAddress::create([
            'user_id' => '32d28339-0967-4548-bc44-fc590c2005a9',
            'address' => '222/34, Moo.5, Nakhonsawan Tok, Meung Nakhonsawan, Nakhonsawan, 60000'
        ]);

        $comment = [
            ['product_id' => '7828a012-f558-4b12-bf78-ab8d26b8b63b', 'user_id' => '32d28339-0967-4548-bc44-fc590c2005a9', 'comment' => 'We will win Premierleague for sure', 'rating' => 5],
            ['product_id' => '2ff97732-3b6b-4f78-96b9-98f8006e28db', 'user_id' => '32d28339-0967-4548-bc44-fc590c2005a9', 'comment' => 'Fxxking expensive. How can I buy this??', 'rating' => 1],
        ];

        foreach ($comment as $c) {
            Comments::create($c);
        }

        $wishlist = [
            ['product_id' => '13c9fceb-f6c9-4d1b-9ee0-ff1693443645', 'user_id' => '32d28339-0967-4548-bc44-fc590c2005a9']
        ];

        foreach ($wishlist as $wl){
            Wishlists::create($wl);
        }
    }
}
