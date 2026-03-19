<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねアイコンを押下することによって、いいねした商品として登録することができる。()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'テスト商品',
            'item_img' => 'test.jpg',
        ]);
        $this->actingAs($user);
        $beforeResponse = $this->get('/item/' . $item->id);
        $beforeResponse->assertOk();
        $beforeResponse->assertSee('0');

        $response = $this->post('/item/' . $item->id . '/like');
        $response->assertRedirect('/item/' . $item->id);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $afterResponse = $this->get('/item/' . $item->id);
        $afterResponse->assertOk();
        $afterResponse->assertSee('1');
    }
    public function test_追加済みのアイコンは色が変化する()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'テスト商品1',
            'item_img' => 'test1.jpg',
        ]);

        $this->actingAs($user);

        $beforeResponse = $this->get('/item/' . $item->id);
        $beforeResponse->assertOk();
        $beforeResponse->assertSee('heartlogo_default.png');

        $response = $this->post('/item/' . $item->id . '/like');
        $response->assertRedirect('/item/' . $item->id);

        $afterResponse = $this->get('/item/' . $item->id);
        $afterResponse->assertOk();

        $afterResponse->assertSee('heartlogo_pink.png');
        $afterResponse->assertDontSee('heartlogo_default.png');
    }
    public function test_再度いいねアイコンを押下することによって、いいねを解除することができる。()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'テスト商品2',
            'item_img' => 'test2.jpg',
        ]);

        $this->actingAs($user);

        $beforeResponse = $this->get('/item/' . $item->id);
        $beforeResponse->assertOk();
        $beforeResponse->assertSee('0');

        $firstResponse = $this->post('/item/' . $item->id . '/like');
        $firstResponse->assertRedirect('/item/' . $item->id);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $afterFirstLikeResponse = $this->get('/item/' . $item->id);
        $afterFirstLikeResponse->assertOk();
        $afterFirstLikeResponse->assertSee('1');

        $secondResponse = $this->post('/item/' . $item->id . '/like');
        $secondResponse->assertRedirect('/item/' . $item->id);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $afterSecondLikeResponse = $this->get('/item/' . $item->id);
        $afterSecondLikeResponse->assertOk();
        $afterSecondLikeResponse->assertSee('0');
    }
}
