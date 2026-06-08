<?php

namespace Tests\Feature\Authorization;

use App\Mail\WelcomeToAkhaniConnectMail;
use App\Models\VerificationRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function superadmin(): User
    {
        return User::query()->where('email', 'connect@gabrielo.co.za')->firstOrFail();
    }

    public function test_authenticated_user_can_view_their_profile_page(): void
    {
        $this->seed();

        $user = User::factory()->withRole(2)->create();
        $user->profile()->create(['country' => 'ZA']);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('My Profile');
    }

    public function test_superadmin_can_access_user_management_page(): void
    {
        $this->seed();

        $admin = $this->superadmin();

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertSee('Registered Users');
    }

    public function test_superadmin_can_access_reports_and_settings_pages(): void
    {
        $this->seed();

        $admin = $this->superadmin();

        $this->actingAs($admin)
            ->get(route('admin.reports.index'))
            ->assertOk()
            ->assertSee('Recent Verification Activity');

        $this->actingAs($admin)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('Platform Settings');
    }

    public function test_superadmin_can_access_verification_logs_page(): void
    {
        $this->seed();

        $admin = $this->superadmin();

        $response = $this->actingAs($admin)->get(route('admin.verifications.index'));

        $response->assertOk();
        $response->assertSee('All Verification Records');
    }

    public function test_superadmin_can_view_a_verification_record_detail_page(): void
    {
        $this->seed();

        $admin = $this->superadmin();
        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $profile = $procurement->procurementProfile()->create([
            'registration_number' => '201408196207',
        ]);

        $record = VerificationRecord::query()->create([
            'user_id' => $procurement->id,
            'module' => 'enterprise',
            'provider' => 'verifynow',
            'status' => 'verified',
            'verifiable_type' => $profile->getMorphClass(),
            'verifiable_id' => $profile->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.verifications.show', $record));

        $response->assertOk();
        $response->assertSee('Verification Details');
    }

    public function test_superadmin_can_download_procurement_report(): void
    {
        $this->seed();

        $admin = $this->superadmin();
        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->procurementProfile()->create([
            'company_name' => 'Akhani Procurement',
            'registration_number' => '201408196207',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.procurement-reports.show', $procurement));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_superadmin_can_create_a_client_account(): void
    {
        $this->seed();
        Mail::fake();

        $admin = $this->superadmin();

        $response = $this->actingAs($admin)->post(route('admin.clients.store'), [
            'first_name' => 'Client',
            'surname' => 'Owner',
            'email' => 'owner@clientco.test',
            'phone' => '0821234500',
            'password' => 'ClientPass123!',
            'password_confirmation' => 'ClientPass123!',
            'status' => 'active',
            'company_name' => 'Client Co',
            'contact_person_name' => 'Client Owner',
            'company_phone' => '0115551000',
            'access_scope' => 'Procurement records - Gauteng',
        ]);

        $response->assertRedirect(route('admin.clients.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'email' => 'owner@clientco.test',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('client_profiles', [
            'company_name' => 'Client Co',
            'access_scope' => 'Procurement records - Gauteng',
        ]);

        Mail::assertSent(WelcomeToAkhaniConnectMail::class, function (WelcomeToAkhaniConnectMail $mail): bool {
            return $mail->hasTo('owner@clientco.test');
        });
    }

    public function test_superadmin_can_create_a_procurement_user_account(): void
    {
        $this->seed();
        Mail::fake();

        $admin = $this->superadmin();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'first_name' => 'Procurement',
            'surname' => 'User',
            'email' => 'procurement-admin-created@test.local',
            'phone' => '0821234501',
            'role' => 'procurement',
            'status' => 'active',
            'password' => 'ProcurePass123!',
            'password_confirmation' => 'ProcurePass123!',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'email' => 'procurement-admin-created@test.local',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('procurement_profiles', [
            'user_id' => User::query()->where('email', 'procurement-admin-created@test.local')->value('id'),
        ]);

        Mail::assertSent(WelcomeToAkhaniConnectMail::class, function (WelcomeToAkhaniConnectMail $mail): bool {
            return $mail->hasTo('procurement-admin-created@test.local');
        });
    }

    public function test_superadmin_can_update_a_managed_user_account(): void
    {
        $this->seed();

        $admin = $this->superadmin();
        $managedUser = User::factory()->withRole(3)->create([
            'email' => 'managed-user@test.local',
            'phone' => '0821234510',
            'status' => 'active',
        ]);
        $managedUser->profile()->create(['country' => 'ZA']);
        $managedUser->recruitmentProfile()->create();

        $response = $this->actingAs($admin)->put(route('admin.users.update', $managedUser), [
            'first_name' => 'Updated',
            'surname' => 'Manager',
            'email' => 'managed-user@test.local',
            'phone' => '0821234510',
            'role' => 'procurement',
            'status' => 'inactive',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'id' => $managedUser->id,
            'first_name' => 'Updated',
            'status' => 'inactive',
        ]);
    }

    public function test_superadmin_can_update_platform_settings(): void
    {
        $this->seed();

        $admin = $this->superadmin();

        $response = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'platform_name' => 'Akhani Connect Ops',
            'support_email' => 'ops@akhaniconnect.co.za',
            'default_country' => 'ZA',
            'registration_welcome_message' => 'Welcome aboard',
        ]);

        $response->assertRedirect(route('admin.settings.edit'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('platform_settings', [
            'key' => 'platform_name',
            'value' => 'Akhani Connect Ops',
        ]);
    }

    public function test_candidate_cannot_access_superadmin_user_management_page(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);

        $response = $this->actingAs($candidate)->get(route('admin.users.index'));

        $response->assertForbidden();
    }

    public function test_candidate_cannot_create_a_client_account(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);

        $response = $this->actingAs($candidate)->post(route('admin.clients.store'), [
            'first_name' => 'Client',
            'surname' => 'Blocked',
            'email' => 'blocked-client@test.local',
            'phone' => '0821234502',
            'password' => 'ClientPass123!',
            'password_confirmation' => 'ClientPass123!',
            'status' => 'active',
            'company_name' => 'Blocked Client Co',
            'contact_person_name' => 'Blocked Contact',
        ]);

        $response->assertForbidden();
    }

    public function test_profile_update_persists_changes_for_authenticated_user(): void
    {
        $this->seed();

        $user = User::factory()->withRole(3)->create();
        $user->profile()->create(['country' => 'ZA']);

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'first_name' => 'Updated',
            'surname' => 'Recruiter',
            'email' => $user->email,
            'phone' => $user->phone,
            'date_of_birth' => '1990-01-01',
            'gender' => 'Female',
            'id_number' => '9001011234088',
            'passport_number' => '',
            'phone_secondary' => '0831234567',
            'address_line_1' => '1 Main Road',
            'address_line_2' => 'Suite 2',
            'suburb' => 'Sandton',
            'city' => 'Johannesburg',
            'province' => 'Gauteng',
            'postal_code' => '2196',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Updated',
            'surname' => 'Recruiter',
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'city' => 'Johannesburg',
            'province' => 'Gauteng',
        ]);
    }

    public function test_authenticated_user_can_upload_a_profile_picture(): void
    {
        $this->seed();
        Storage::fake('public');

        $user = User::factory()->withRole(3)->create();
        $user->profile()->create(['country' => 'ZA']);

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'first_name' => 'Updated',
            'surname' => 'Recruiter',
            'email' => $user->email,
            'phone' => $user->phone,
            'profile_picture' => UploadedFile::fake()->image('avatar.png', 300, 300),
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status');

        $user->refresh();

        $this->assertNotNull($user->profile?->avatar_path);
        Storage::disk('public')->assertExists($user->profile->avatar_path);

        $avatarResponse = $this->actingAs($user)->get(route('profile.avatar.show', $user->profile));
        $avatarResponse->assertOk();
    }
}
