<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_会員登録後、認証メールが送信される()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'testUser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect();

        $user = User::where('email', 'test@example.com')->first();

        $this->assertNotNull($user);

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }
    public function test_メール認証誘導画面で「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $this->actingAs($user);
        $response = $this->get('/email/verify');
        $response->assertStatus(200);
        $response->assertSee('認証はこちらから');
        $response->assertSee('http://localhost:8025');
    }
    public function test_メール認証サイトのメール認証を完了すると、プロフィール設定画面に遷移する()
    {
         Notification::fake();
        $registerResponse = $this->post('/register', [
            'name' => 'testUser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $registerResponse->assertRedirect(route('profile.edit'));

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);

        Notification::assertSentTo($user, VerifyEmail::class);

        $this->actingAs($user);

        $verifyPageResponse = $this->get('/email/verify');
        $verifyPageResponse->assertOk();
        $verifyPageResponse->assertSee('認証はこちらから');

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $verifyResponse = $this->get($verificationUrl);

        $verifyResponse->assertRedirect(route('profile.edit'));

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
