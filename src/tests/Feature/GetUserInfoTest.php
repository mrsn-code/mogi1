<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserInfoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_必要な情報が取得できる()
    {
        $user = User::factory()->create([
            'name' => '山田太郎',
            'icon_img' => 'users/test-icon.jpg',
        ]);

        $otherUser = User::factory()->create();

        Item::factory()->create([
            'user_id' => $user->id,
            'buyer_id' => null,
            'item_name' => '出品商品1',
            'item_img' => 'sell1.jpg',
        ]);

        Item::factory()->create([
            'user_id' => $user->id,
            'buyer_id' => null,
            'item_name' => '出品商品2',
            'item_img' => 'sell2.jpg',
        ]);

        Item::factory()->create([
            'user_id' => $otherUser->id,
            'buyer_id' => $user->id,
            'item_name' => '購入商品1',
            'item_img' => 'buy1.jpg',
        ]);

        Item::factory()->create([
            'user_id' => $otherUser->id,
            'buyer_id' => $user->id,
            'item_name' => '購入商品2',
            'item_img' => 'buy2.jpg',
        ]);

        Item::factory()->create([
            'user_id' => $otherUser->id,
            'buyer_id' => null,
            'item_name' => '関係ない商品',
            'item_img' => 'other.jpg',
        ]);

        $this->actingAs($user);

        $sellResponse = $this->get('/mypage?tab=sell');
        $sellResponse->assertOk();
        $sellResponse->assertSee('users/test-icon.jpg');
        $sellResponse->assertSee('山田太郎');
        $sellResponse->assertSee('出品商品1');
        $sellResponse->assertSee('出品商品2');
        $sellResponse->assertDontSee('購入商品1');
        $sellResponse->assertDontSee('購入商品2');
        $sellResponse->assertDontSee('関係ない商品');

        $buyResponse = $this->get('/mypage?tab=buy');
        $buyResponse->assertOk();
        $buyResponse->assertSee('users/test-icon.jpg');
        $buyResponse->assertSee('山田太郎');
        $buyResponse->assertSee('購入商品1');
        $buyResponse->assertSee('購入商品2');
        $buyResponse->assertDontSee('出品商品1');
        $buyResponse->assertDontSee('出品商品2');
        $buyResponse->assertDontSee('関係ない商品');
    }
}
