<?php

namespace Tests\Feature\Auth;

use App\Mail\WelcomeToAkhaniConnectMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_can_register_with_a_permitted_role(): void
    {
        $this->seed();
        Mail::fake();

        $response = $this->post(route('register.store'), [
            'first_name' => 'Naledi',
            'surname' => 'Khumalo',
            'email' => 'naledi@example.test',
            'phone' => '0821234567',
            'role' => 'candidate',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]);

        $response->assertRedirect(route('candidate.identity-verification.show'));

        $this->assertDatabaseHas('users', [
            'email' => 'naledi@example.test',
            'role_id' => Role::where('slug', 'candidate')->value('id'),
        ]);

        $this->assertDatabaseHas('profiles', [
            'country' => 'ZA',
        ]);

        Mail::assertSent(WelcomeToAkhaniConnectMail::class, function (WelcomeToAkhaniConnectMail $mail): bool {
            return $mail->hasTo('naledi@example.test');
        });
    }

    public function test_client_cannot_self_register(): void
    {
        $this->seed();

        $response = $this->from(route('register'))->post(route('register.store'), [
            'first_name' => 'Client',
            'surname' => 'User',
            'email' => 'client@example.test',
            'phone' => '0821234568',
            'role' => 'client',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('role');
    }

    public function test_superadmin_login_redirects_to_admin_dashboard(): void
    {
        $this->seed();

        $response = $this->post(route('login.store'), [
            'email' => 'superadmin@akhaniconnect.co.za',
            'password' => 'ChangeMe123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_procurement_user_login_redirects_to_identity_verification_when_not_verified(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create([
            'email' => 'procurement@example.test',
            'password' => 'SecurePass123!',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'SecurePass123!',
        ]);

        $response->assertRedirect(route('procurement.identity-verification.show'));
    }

    public function test_verified_candidate_login_redirects_to_candidate_dashboard(): void
    {
        $this->seed();

        $user = User::factory()->withRole(2)->create([
            'email' => 'verified-candidate@example.test',
            'password' => 'SecurePass123!',
        ]);
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'SecurePass123!',
        ]);

        $response->assertRedirect(route('candidate.dashboard'));
    }

    public function test_user_can_request_a_password_reset_link(): void
    {
        $this->seed();
        Notification::fake();

        $user = User::factory()->withRole(2)->create([
            'email' => 'reset@example.test',
        ]);

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_user_can_reset_password_with_valid_token(): void
    {
        $this->seed();

        $user = User::factory()->withRole(2)->create([
            'email' => 'reset-password@example.test',
            'password' => 'OldPassword123!',
        ]);

        $token = Password::broker()->createToken($user);

        $response = $this->post(route('password.store'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');

        $loginResponse = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'NewSecurePass123!',
        ]);

        $loginResponse->assertRedirect(route('candidate.identity-verification.show'));
    }

    public function test_welcome_email_template_contains_akhani_logo(): void
    {
        $this->seed();

        $user = User::factory()->withRole(2)->make([
            'first_name' => 'Naledi',
            'email' => 'naledi@example.test',
        ]);
        $user->setRelation('role', Role::query()->where('slug', 'candidate')->firstOrFail());

        $mail = new WelcomeToAkhaniConnectMail($user, [
            'platform_name' => 'Akhani Connect',
            'support_email' => 'support@akhaniconnect.co.za',
            'registration_welcome_message' => 'Welcome to Akhani Connect',
        ]);

        $rendered = $mail->render();

        $this->assertStringContainsString('logo.png', $rendered);
        $this->assertStringContainsString('Welcome to Akhani Connect', $rendered);
    }
}
