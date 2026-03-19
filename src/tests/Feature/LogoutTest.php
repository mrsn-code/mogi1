<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ログアウトができる() {
            $user = User::factory()->create();
            $this->actingAs($user);
            $this->assertAuthenticated();
            $response = $this->post('/logout');
            $this->assertGuest();
        }
}
