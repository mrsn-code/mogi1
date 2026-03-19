<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditUserInfoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_変更項目が初期値として過去設定されていること()
    {
        $user = User::factory()->create([
            'name' => '山田太郎',
            'zipcode' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストマンション',
            'icon_img' => 'users/test-icon.jpg',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('value="山田太郎"', false);
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('value="東京都渋谷区1-1-1"', false);
        $response->assertSee('value="テストマンション"', false);
        $response->assertSee('users/test-icon.jpg');
    }
}
