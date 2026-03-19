<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_全商品を取得できる() {
        Item::factory()->count(3)->create();
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSeeText(Item::first()->name);

    }
    public function test_購入済み商品は「Sold」と表示される() {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $soldItem = Item::factory()->create([
            'user_id' => $seller->id,
            'buyer_id' => $buyer->id,
            'item_name' => '購入済み商品',
            'item_img' => 'sold-item.jpg',
        ]);
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('購入済み商品');
        $response->assertSee('sold');
    }
    public function test_自分が出品した商品は表示されない() {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $myItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '自分の商品',
            'item_img' => 'my-item.jpg',
        ]);
        $otherItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'item_name' => '他人の商品',
            'item_img' => 'other-item.jpg',
        ]);
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertOk();
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}
