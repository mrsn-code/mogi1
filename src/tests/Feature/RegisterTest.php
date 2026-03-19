<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_name_request() {
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
    public function test_email_request() {
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
    public function test_password_request() {
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
    public function test_password_min_request() {
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
    public function test_password_confirmation_request() {
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
    public function test_registration_success() {
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