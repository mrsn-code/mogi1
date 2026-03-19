<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_メールアドレスが入力されていない場合、バリデーションメッセージが表示される() {
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
    public function test_パスワードが入力されていない場合、バリデーションメッセージが表示される() {
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
    public function test_入力情報が間違っている場合、バリデーションメッセージが表示される() {
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
    public function test_正しい情報が入力された場合、ログイン処理が実行される() {
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
