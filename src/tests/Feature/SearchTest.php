<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_「商品名」で部分一致検索ができる()
    {
        Item::factory()->create([
            'item_name' => 'ノートパソコン',
            'item_img' => 'pc.jpg',
        ]);
        Item::factory()->create([
            'item_name' => 'ノートブック',
            'item_img' => 'notebook.jpg',
        ]);
        $response = $this->get('/?keyword=パソコン');
        $response->assertOk();
        $response->assertSee('ノートパソコン');
        $response->assertDontSee('ノートブック');
    }
    public function test_検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item1 = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'ノートブック',
            'item_img' => 'notebook.jpg',
        ]);

        $item2 = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'ノートパソコン',
            'item_img' => 'pc.jpg',
        ]);

        $user->likedItems()->attach([$item1->id, $item2->id]);

        $this->actingAs($user);

        $response = $this->get('/?tab=index&keyword=ブック');
        $response->assertOk();
        $response->assertSee('ノートブック');
        $response->assertDontSee('ノートパソコン');

        $mylistResponse = $this->get('/?tab=mylist&keyword=ブック');
        $mylistResponse->assertOk();
        $mylistResponse->assertSee('ノートブック');
        $mylistResponse->assertDontSee('ノートパソコン');
        $mylistResponse->assertSee('value="ブック"', false);
    }
}
