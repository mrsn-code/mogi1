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
    }
}
