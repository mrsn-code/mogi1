<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_名前が入力されていない場合、バリデーションメッセージが表示される() {
        $this->get('/register')->assertStatus(200);

        $response = $this->post('/register', [
            'name' => '',
            'email' => 'testCase@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors('name');
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }
    public function test_メールアドレスが入力されていない場合、バリデーションメッセージが表示される() {
        $this->get('/register')->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'testCase',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }
    public function test_パスワードが入力されていない場合、バリデーションメッセージが表示される() {
        $this->get('/register')->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'testCase',
            'email' => 'testCase@example.com',
            'password' => '',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors('password');
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }
    public function test_パスワードが7文字以下の場合、バリデーションメッセージが表示される() {
        $this->get('/register')->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'testCase',
            'email' => 'testCase@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);
        $response->assertSessionHasErrors('password');
        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }
    public function test_パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される() {
        $this->get('/register')->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'testCase',
            'email' => 'testCase@example.com',
            'password' => 'pass1234',
            'password_confirmation' => 'pass4321',
        ]);
        $response->assertSessionHasErrors('password_confirmation');
        $response->assertSessionHasErrors([
            'password_confirmation' => 'パスワードと一致しません',
        ]);
    }
    public function test_全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される() {
        $this->get('/register')->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'testCase',
            'email' => 'testCase@example.com',
            'password' => 'pass1234',
            'password_confirmation' => 'pass1234',
        ]);
        $response->assertRedirect(route('profile.edit'));
        $this->assertDatabaseHas('users', [
            'name' => 'testCase',
            'email' => 'testCase@example.com',
        ]);
    }
}