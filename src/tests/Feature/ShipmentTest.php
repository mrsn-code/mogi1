<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShipmentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_送付先住所変更画面にて登録した住所が商品購入画面に反映されている()
    {
        $buyer = User::factory()->create([
            'zipcode' => '111-1111',
            'address' => '東京都新宿区1-1-1',
            'building' => '旧住所ビル',
        ]);

        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'テスト商品',
            'item_img' => 'test.jpg',
        ]);

        $this->actingAs($buyer);

        $this->get(route('purchase.show', $item))->assertOk();
        $response = $this->post(route('purchase.address.update', $item), [
            'zipcode' => '222-2222',
            'address' => '大阪府大阪市2-2-2',
            'building' => '新住所マンション',
        ]);

        $response->assertRedirect(route('purchase.show', $item));
        $response->assertSessionHas('purchase_shipping.zipcode', '222-2222');
        $response->assertSessionHas('purchase_shipping.address', '大阪府大阪市2-2-2');
        $response->assertSessionHas('purchase_shipping.building', '新住所マンション');

        $purchasePage = $this->get(route('purchase.show', $item));
        $purchasePage->assertOk();
        
        $purchasePage->assertSee('222-2222');
        $purchasePage->assertSee('大阪府大阪市2-2-2');
        $purchasePage->assertSee('新住所マンション');
    }
    use RefreshDatabase;
    public function test_購入した商品に送付先住所が紐づいて登録される()
    {
    }
}
