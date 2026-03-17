<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        if (! $user) {
            $user = User::create([
                'name' => 'test user',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        $categoryMap = Category::pluck('id', 'name');
        $item1 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/Armani+Mens+Clock.jpg',
            'item_name' => '腕時計',
            'brand_name' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition' => 'excellent',
            'price' => 15000,
            ]);
        $item2 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/HDD+Hard+Disk.jpg',
            'item_name' => 'HDD',
            'brand_name' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'condition' => 'good',
            'price' => 5000,
            ]);
        $item3 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/iLoveIMG+d.jpg',
            'item_name' => '玉ねぎ3束',
            'brand_name' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'condition' => 'fair',
            'price' => 300,
            ]);
        $item4 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/Leather+Shoes+Product+Photo.jpg',
            'item_name' => '革靴',
            'brand_name' => '',
            'description' => 'クラシックなデザインの革靴',
            'condition' => 'poor',
            'price' => 4000,
            ]);
        $item5 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/Living+Room+Laptop.jpg',
            'item_name' => 'ノートPC',
            'brand_name' => '',
            'description' => '高性能なノートパソコン',
            'condition' => 'excellent',
            'price' => 45000,
            ]);
        $item6 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/Music+Mic+4632231.jpg',
            'item_name' => 'マイク',
            'brand_name' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'condition' => 'good',
            'price' => 8000,
            ]);
        $item7 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/Purse+fashion+pocket.jpg',
            'item_name' => 'ショルダーバッグ',
            'brand_name' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'condition' => 'fair',
            'price' => 3500,
            ]);
        $item8 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/Tumbler+souvenir.jpg',
            'item_name' => 'タンブラー',
            'brand_name' => 'なし',
            'description' => '使いやすいタンブラー',
            'condition' => 'poor',
            'price' => 500,
            ]);
        $item9 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'item_name' => 'コーヒーミル',
            'brand_name' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'condition' => 'excellent',
            'price' => 4000,
            ]);
        $item10 = Item::create([
            'user_id' => $user->id,
            'item_img' => 'images/外出メイクアップセット.jpg',
            'item_name' => 'メイクセット',
            'brand_name' => '',
            'description' => '便利なメイクアップセット',
            'condition' => 'good',
            'price' => 2500,
            ]);
        
        $item1->categories()->attach([
            $categoryMap['ファッション'],
            $categoryMap['メンズ'],
        ]);
        $item2->categories()->attach([
            $categoryMap['家電'],
        ]);
        $item3->categories()->attach([
            $categoryMap['キッチン'],
        ]);
        $item4->categories()->attach([
            $categoryMap['ファッション'],
            $categoryMap['メンズ'],
        ]);
        $item5->categories()->attach([
            $categoryMap['家電'],
        ]);
        $item6->categories()->attach([
            $categoryMap['家電'],
            $categoryMap['インテリア'],
        ]);
        $item7->categories()->attach([
            $categoryMap['ファッション'],
            $categoryMap['アクセサリー'],
        ]);
        $item8->categories()->attach([
            $categoryMap['キッチン'],
            $categoryMap['アクセサリー'],
        ]);
        $item9->categories()->attach([
            $categoryMap['キッチン'],
        ]);
        $item10->categories()->attach([
            $categoryMap['ファッション'],
            $categoryMap['レディース'],
        ]);
    }
}
// <?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;

// class ItemsTableSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      *
//      * @return void
//      */
//     public function run()
//     {
//         $params = [
//             'item_img' => 'images/Armani+Mens+Clock.jpg',
//             'item_name' => '腕時計',
//             'brand_name' => 'Rolax',
//             'description' => 'スタイリッシュなデザインのメンズ腕時計',
//             'condition' => 'excellent',
//             'price' => 15000,
//             ];
//             DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/HDD+Hard+Disk.jpg',
//             'item_name' => 'HDD',
//             'brand_name' => '西芝',
//             'description' => '高速で信頼性の高いハードディスク',
//             'condition' => 'good',
//             'price' => 5000,
//         ];
//         DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/iLoveIMG+d.jpg',
//             'item_name' => '玉ねぎ3束',
//             'brand_name' => 'なし',
//             'description' => '新鮮な玉ねぎ3束のセット',
//             'condition' => 'fair',
//             'price' => 300,
//         ];
//         DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/Leather+Shoes+Product+Photo.jpg',
//             'item_name' => '革靴',
//             'brand_name' => '',
//             'description' => 'クラシックなデザインの革靴',
//             'condition' => 'poor',
//             'price' => 4000,
//         ];
//         DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/Living+Room+Laptop.jpg',
//             'item_name' => 'ノートPC',
//             'brand_name' => '',
//             'description' => '高性能なノートパソコン',
//             'condition' => 'excellent',
//             'price' => 45000,
//         ];
//         DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/Music+Mic+4632231.jpg',
//             'item_name' => 'マイク',
//             'brand_name' => 'なし',
//             'description' => '高音質のレコーディング用マイク',
//             'condition' => 'good',
//             'price' => 8000,
//         ];
//         DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/Purse+fashion+pocket.jpg',
//             'item_name' => 'ショルダーバッグ',
//             'brand_name' => '',
//             'description' => 'おしゃれなショルダーバッグ',
//             'condition' => 'fair',
//             'price' => 3500,
//         ];
//         DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/Tumbler+souvenir.jpg',
//             'item_name' => 'タンブラー',
//             'brand_name' => 'なし',
//             'description' => '使いやすいタンブラー',
//             'condition' => 'poor',
//             'price' => 500,
//         ];
//         DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/Waitress+with+Coffee+Grinder.jpg',
//             'item_name' => 'コーヒーミル',
//             'brand_name' => 'Starbacks',
//             'description' => '手動のコーヒーミル',
//             'condition' => 'excellent',
//             'price' => 4000,
//         ];
//         DB::table('items') -> insert($params);
//         $params = [
//             'item_img' => 'images/外出メイクアップセット.jpg',
//             'item_name' => 'メイクセット',
//             'brand_name' => '',
//             'description' => '便利なメイクアップセット',
//             'condition' => 'good',
//             'price' => 2500,
//         ];
//         DB::table('items') -> insert($params);
//     }
// }
