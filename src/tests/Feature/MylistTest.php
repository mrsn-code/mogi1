<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねした商品だけが表示される()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $likedItem = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'いいねした商品',
            'item_img' => 'liked.jpg',
        ]);
        $notLikedItem = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'いいねしていない商品',
            'item_img' => 'not-liked.jpg',
        ]);
        $user->likedItems()->attach($likedItem->id);
        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');
        $response->assertOk();
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }
    public function test_購入済み商品は「Sold」と表示される()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $soldItem = Item::factory()->create([
            'user_id' => $seller->id,
            'buyer_id' => $user->id,
            'item_name' => '購入済みの商品',
            'item_img' => 'sold-item.jpg',
        ]);
        $user->likedItems()->attach($soldItem->id);
        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');
        $response->assertOk();
        $response->assertSee('購入済みの商品');
        $response->assertSee('sold');
    }
    public function test_未認証の場合は何も表示されない()
    {
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'いいねした商品',
            'item_img' => 'sample.jpg',
        ]);
        $response = $this->get('/?tab=mylist');
        $response->assertDontSee('いいねした商品');
    }
}
