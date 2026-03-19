<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ログイン済みのユーザーはコメントを送信できる()
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
        $beforeResponse->assertSee('コメント(0)');
        $response = $this->post('/item/' . $item->id . '/comments', [
            'comment' => 'とても良い商品ですね',
        ]);
        $response->assertRedirect('/item/' . $item->id);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'とても良い商品ですね',
        ]);

        $afterResponse = $this->get('/item/' . $item->id);
        $afterResponse->assertOk();
        $afterResponse->assertSee('コメント(1)');

        $afterResponse->assertSee('とても良い商品ですね');
    }
    public function test_ログイン前のユーザーはコメントを送信できない()
    {
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'テスト商品2',
            'item_img' => 'test2.jpg',
        ]);

        $response = $this->post('/item/' . $item->id . '/comments', [
            'comment' => '未ログインで送信するコメント',
        ]);

        // ログイン画面へリダイレクトされる
        $response->assertRedirect('/login');

        // コメントは保存されない
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'comment' => '未ログインで送信するコメント',
        ]);
    }
    public function test_コメントが入力されていない場合、バリデーションメッセージが表示される()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'テスト商品3',
            'item_img' => 'test3.jpg',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('items.comments.store', $item), [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');

        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }
    public function test_コメントが255字以上の場合、バリデーションメッセージが表示される()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'テスト商品4',
            'item_img' => 'test4.jpg',
        ]);

        $this->actingAs($user);

        $longComment = str_repeat('a', 256);

        $response = $this->post(route('items.comments.store', $item), [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors('comment');

        $response->assertSessionHasErrors([
            'comment' => 'コメントは255文字以内で入力してください',
        ]);
    }
}
