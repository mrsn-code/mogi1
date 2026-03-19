<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DetailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_必要な情報が表示される()
    {
        $seller = User::factory()->create([
            'name' => '出品者ユーザー',
        ]);
        $commentUser = User::factory()->create([
            'name' => 'コメントユーザー',
        ]);
        $likeUser1 = User::factory()->create();
        $likeUser2 = User::factory()->create();

        $category1 = Category::factory()->create([
            'name' => '文房具',
        ]);
        $category2 = Category::factory()->create([
            'name' => '学生アイテム',
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'notebook',
            'brand_name' => 'kokuyo',
            'price' => 150,
            'description' => 'good notebook',
            'condition' => 'excellent',
            'item_img' => 'notebook.jpg',
        ]);

        $item->categories()->attach([$category1->id, $category2->id]);
        $item->likedUsers()->attach([$likeUser1->id, $likeUser2->id]);

        $comment = Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
            'comment' => 'とても良い商品ですね',
        ]);

        $response = $this->get('/item/' . $item->id);
        $response->assertOk();

        $response->assertSee('notebook.jpg');
        $response->assertSee('notebook');
        $response->assertSee('kokuyo');
        $response->assertSee('150');
        $response->assertSee('2');
        $response->assertSee('1');
        $response->assertSee('good notebook');
        $response->assertSee('文房具');
        $response->assertSee('学生アイテム');
        $response->assertSee('良好');
        $response->assertSee('コメントユーザー');
        $response->assertSee('とても良い商品ですね');
    }
    public function test_複数選択されたカテゴリが表示されているか()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => 'ジャケット',
            'item_img' => 'jacket.jpg',
        ]);
        $category1 = Category::factory()->create([
            'name' => '衣服',
        ]);
        $category2 = Category::factory()->create([
            'name' => 'カジュアル',
        ]);
        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get('/item/' . $item->id);

        $response->assertOk();
        $response->assertSee('衣服');
        $response->assertSee('カジュアル');
    }
}
