<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_email_request() {
        $this->get('/login')->assertStatus(200);

        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
        $this->assertGuest();
    }
    public function test_password_request() {
        $this->get('/login')->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'testCase@example.com',
            'password' => '',
        ]);
        $response->assertSessionHasErrors('password');
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
        $this->assertGuest();
    }
    public function test_false_user() {
        $this->get('/login')->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'testCase@example.com',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
        $this->assertGuest();
    }
    public function test_login_success() {
        $user = User::factory()->create();
        $this->get('/login')->assertStatus(200);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);
    }
}
