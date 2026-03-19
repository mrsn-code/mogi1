<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExhibitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_商品出品画面にて必要な情報が保存できること()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category1 = Category::factory()->create([
            'name' => 'ファッション',
        ]);
        $category2 = Category::factory()->create([
            'name' => 'メンズ',
        ]);
        $this->actingAs($user);

        $this->get(route('items.create'))->assertOk();

        $image = UploadedFile::fake()->create('test-item.jpg', 100);
        $response = $this->post(route('items.store'), [
            'item_name' => 'レザーバッグ',
            'brand_name' => 'COACH',
            'price' => 15000,
            'description' => '高級感のあるレザーバッグです',
            'condition' => '良好',
            'categories' => [$category1->id, $category2->id],
            'item_img' => $image,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'item_name' => 'レザーバッグ',
            'brand_name' => 'COACH',
            'price' => 15000,
            'description' => '高級感のあるレザーバッグです',
            'condition' => '良好',
        ]);

        $item = \App\Models\Item::where('item_name', 'レザーバッグ')->first();

        $this->assertNotNull($item);
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category1->id,
        ]);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category2->id,
        ]);
        Storage::disk('public')->assertExists($item->item_img);
    }
}
