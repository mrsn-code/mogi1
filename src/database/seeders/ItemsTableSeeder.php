<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'item_img' => 'images/Armani+Mens+Clock.jpg',
            'item_name' => '腕時計',
            'brand_name' => 'Rolax',
            'price' => 15000,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/HDD+Hard+Disk.jpg',
            'item_name' => 'HDD',
            'brand_name' => '西芝',
            'price' => 5000,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/iLoveIMG+d.jpg',
            'item_name' => '玉ねぎ3束',
            'brand_name' => 'なし',
            'price' => 300,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/Leather+Shoes+Product+Photo.jpg',
            'item_name' => '革靴',
            'brand_name' => '',
            'price' => 4000,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/Living+Room+Laptop.jpg',
            'item_name' => 'ノートPC',
            'brand_name' => '',
            'price' => 45000,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/Music+Mic+4632231.jpg',
            'item_name' => 'マイク',
            'brand_name' => 'なし',
            'price' => 8000,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/Purse+fashion+pocket.jpg',
            'item_name' => 'ショルダーバッグ',
            'brand_name' => '',
            'price' => 3500,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/Tumbler+souvenir.jpg',
            'item_name' => 'タンブラー',
            'brand_name' => 'なし',
            'price' => 500,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'item_name' => 'コーヒーミル',
            'brand_name' => 'Starbacks',
            'price' => 4000,
        ];
        DB::table('items') -> insert($params);
        $params = [
            'item_img' => 'images/外出メイクアップセット.jpg',
            'item_name' => 'メイクセット',
            'brand_name' => '',
            'price' => 2500,
        ];
        DB::table('items') -> insert($params);
    }
}
