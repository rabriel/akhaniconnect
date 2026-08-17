<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PopiaAcknowledgementTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_login_redirects_to_popia_page_for_all_roles(): void
    {
        $this->seed();

        $users = [
            User::factory()->withRole((int) Role::where('slug', 'candidate')->value('id'))->create([
                'email' => 'popia-candidate@example.test',
                'password' => 'SecurePass123!',
            ]),
            User::factory()->withRole((int) Role::where('slug', 'recruitment')->value('id'))->create([
                'email' => 'popia-recruitment@example.test',
                'password' => 'SecurePass123!',
            ]),
            User::factory()->withRole((int) Role::where('slug', 'procurement')->value('id'))->create([
                'email' => 'popia-procurement@example.test',
                'password' => 'SecurePass123!',
            ]),
            User::factory()->withRole((int) Role::where('slug', 'client')->value('id'))->create([
                'email' => 'popia-client@example.test',
                'password' => 'SecurePass123!',
            ]),
        ];

        foreach ($users as $user) {
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();

            $response = $this->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'SecurePass123!',
            ]);

            $response->assertRedirect(route('popia.notice.show'));
            $this->assertAuthenticatedAs($user);
        }

        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        $adminResponse = $this->post(route('login.store'), [
            'email' => 'admin@akhaniconnect.co.za',
            'password' => 'Akhaniconnect!1',
        ]);

        $adminResponse->assertRedirect(route('popia.notice.show'));
    }

    public function test_user_cannot_access_dashboard_before_acknowledgement(): void
    {
        $this->seed();

        $response = $this->post(route('login.store'), [
            'email' => 'admin@akhaniconnect.co.za',
            'password' => 'Akhaniconnect!1',
        ]);

        $response->assertRedirect(route('popia.notice.show'));

        $dashboardResponse = $this->get(route('dashboard'));

        $dashboardResponse->assertRedirect(route('popia.notice.show'));
    }

    public function test_user_can_acknowledge_popia_and_an_audit_record_is_created(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole((int) Role::where('slug', 'candidate')->value('id'))->create([
            'email' => 'acknowledged-candidate@example.test',
            'password' => 'SecurePass123!',
        ]);
        $candidate->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $this->post(route('login.store'), [
            'email' => $candidate->email,
            'password' => 'SecurePass123!',
        ])->assertRedirect(route('popia.notice.show'));

        $response = $this->post(route('popia.notice.store'), [
            'acknowledged' => '1',
        ]);

        $response->assertRedirect(route('candidate.dashboard'));
        $this->assertTrue((bool) session('popia_acknowledged'));

        $this->assertDatabaseHas('privacy_acknowledgements', [
            'user_id' => $candidate->id,
            'privacy_notice_version' => '2026-08-17',
        ]);
    }

    public function test_popia_page_does_not_repeat_during_the_same_login_session(): void
    {
        $this->seed();

        $this->post(route('login.store'), [
            'email' => 'admin@akhaniconnect.co.za',
            'password' => 'Akhaniconnect!1',
        ])->assertRedirect(route('popia.notice.show'));

        $this->post(route('popia.notice.store'), [
            'acknowledged' => '1',
        ])->assertRedirect(route('admin.dashboard'));

        $this->get(route('popia.notice.show'))
            ->assertRedirect(route('admin.dashboard'));

        $this->get(route('dashboard'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_logout_clears_popia_acknowledgement_and_login_requires_it_again(): void
    {
        $this->seed();

        $this->post(route('login.store'), [
            'email' => 'admin@akhaniconnect.co.za',
            'password' => 'Akhaniconnect!1',
        ])->assertRedirect(route('popia.notice.show'));

        $this->post(route('popia.notice.store'), [
            'acknowledged' => '1',
        ])->assertRedirect(route('admin.dashboard'));

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();

        $this->post(route('login.store'), [
            'email' => 'admin@akhaniconnect.co.za',
            'password' => 'Akhaniconnect!1',
        ])->assertRedirect(route('popia.notice.show'));
    }

    public function test_all_roles_can_acknowledge_popia_and_continue_to_their_next_destination(): void
    {
        $this->seed();

        $roleRoutes = [
            'superadmin' => ['email' => 'admin@akhaniconnect.co.za', 'password' => 'Akhaniconnect!1', 'route' => 'admin.dashboard'],
            'candidate' => ['email' => 'all-roles-candidate@example.test', 'password' => 'SecurePass123!', 'route' => 'candidate.dashboard'],
            'recruitment' => ['email' => 'all-roles-recruitment@example.test', 'password' => 'SecurePass123!', 'route' => 'recruitment.dashboard'],
            'procurement' => ['email' => 'all-roles-procurement@example.test', 'password' => 'SecurePass123!', 'route' => 'procurement.dashboard'],
            'client' => ['email' => 'all-roles-client@example.test', 'password' => 'SecurePass123!', 'route' => 'client.dashboard'],
        ];

        $roleIds = Role::query()->pluck('id', 'slug');

        foreach (['candidate', 'recruitment', 'procurement', 'client'] as $slug) {
            $user = User::factory()->withRole((int) $roleIds[$slug])->create([
                'email' => $roleRoutes[$slug]['email'],
                'password' => $roleRoutes[$slug]['password'],
            ]);

            $user->verificationRecords()->create([
                'module' => 'sa_identity',
                'provider' => 'verifynow',
                'status' => 'verified',
            ]);
        }

        foreach ($roleRoutes as $details) {
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();

            $this->post(route('login.store'), [
                'email' => $details['email'],
                'password' => $details['password'],
            ])->assertRedirect(route('popia.notice.show'));

            $this->post(route('popia.notice.store'), [
                'acknowledged' => '1',
            ])->assertRedirect(route($details['route']));
        }
    }
}
