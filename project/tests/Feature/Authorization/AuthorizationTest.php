<?php

namespace Tests\Feature\Authorization;

use App\Mail\WelcomeToAkhaniConnectMail;
use App\Models\UserActivity;
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
        return User::query()->where('email', 'admin@akhaniconnect.co.za')->firstOrFail();
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

    public function test_superadmin_can_access_analytics_page(): void
    {
        $this->seed();

        $admin = $this->superadmin();

        $response = $this->actingAs($admin)->get(route('admin.analytics.index'));

        $response->assertOk();
        $response->assertSee('Analytics & Activity');
        $response->assertSee('Activity Log');
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

    public function test_superadmin_can_view_a_procurement_user_detail_page(): void
    {
        $this->seed();

        $admin = $this->superadmin();
        $procurement = User::factory()->withRole(4)->create([
            'first_name' => 'Lerato',
            'surname' => 'Mabena',
        ]);
        $procurement->profile()->create([
            'country' => 'ZA',
            'id_number' => '8905155324082',
            'city' => 'Johannesburg',
        ]);
        $profile = $procurement->procurementProfile()->create([
            'company_name' => 'Akhani Procurement Services',
            'registration_number' => '201408196207',
            'verification_progress' => 100,
        ]);
        $procurement->verificationRecords()->create([
            'module' => 'enterprise',
            'provider' => 'verifynow',
            'status' => 'verified',
            'provider_reference' => 'enterprise-ref-1',
        ]);
        $profile->directors()->create([
            'full_name' => 'John Director',
            'id_number' => '8001015009087',
            'status' => 'verified',
            'director_status' => 'Success',
        ]);
        $procurement->documents()->create([
            'category' => 'procurement_profile',
            'type' => 'supporting_document',
            'display_name' => 'BBBEE Certificate',
            'original_name' => 'bbbee.pdf',
            'path' => 'documents/procurement_profile/bbbee.pdf',
            'mime_type' => 'application/pdf',
            'size' => 512,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.show', $procurement));

        $response->assertOk();
        $response->assertSee('Procurement Data Review');
        $response->assertSee('Akhani Procurement Services');
        $response->assertSee('BBBEE Certificate');
    }

    public function test_superadmin_can_view_a_candidate_user_detail_page(): void
    {
        $this->seed();

        $admin = $this->superadmin();
        $candidate = User::factory()->withRole(2)->create([
            'first_name' => 'Naledi',
            'surname' => 'Candidate',
        ]);
        $candidate->profile()->create([
            'country' => 'ZA',
            'city' => 'Pretoria',
            'province' => 'Gauteng',
        ]);
        $candidate->candidateProfile()->create([
            'job_title' => 'Procurement Administrator',
            'experience_level' => 'Mid-level',
            'skills' => 'Excel, sourcing, reporting',
        ]);
        $candidate->documents()->create([
            'category' => 'candidate_profile',
            'type' => 'cv',
            'original_name' => 'candidate-cv.pdf',
            'path' => 'documents/candidate_profile/candidate-cv.pdf',
            'mime_type' => 'application/pdf',
            'size' => 256,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.show', $candidate));

        $response->assertOk();
        $response->assertSee('Candidate Data Review');
        $response->assertSee('Procurement Administrator');
        $response->assertSee('candidate-cv.pdf');
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

    public function test_superadmin_can_download_procurement_supporting_document(): void
    {
        $this->seed();
        Storage::fake('public');

        $admin = $this->superadmin();
        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->procurementProfile()->create();
        Storage::disk('public')->put('documents/procurement_profile/bbbee.pdf', 'document');
        $document = $procurement->documents()->create([
            'category' => 'procurement_profile',
            'type' => 'supporting_document',
            'display_name' => 'BBBEE Certificate',
            'original_name' => 'bbbee.pdf',
            'path' => 'documents/procurement_profile/bbbee.pdf',
            'mime_type' => 'application/pdf',
            'size' => 8,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.procurement-reports.documents.show', [$procurement, $document]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_superadmin_can_download_candidate_document(): void
    {
        $this->seed();
        Storage::fake('public');

        $admin = $this->superadmin();
        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();
        Storage::disk('public')->put('documents/candidate_profile/candidate-cv.pdf', 'document');
        $document = $candidate->documents()->create([
            'category' => 'candidate_profile',
            'type' => 'cv',
            'original_name' => 'candidate-cv.pdf',
            'path' => 'documents/candidate_profile/candidate-cv.pdf',
            'mime_type' => 'application/pdf',
            'size' => 8,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.candidates.documents.show', [$candidate, $document]));

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

    public function test_authenticated_visit_is_tracked_with_ip_country_and_browser_details(): void
    {
        $this->seed();

        $admin = $this->superadmin();

        $this->withServerVariables([
            'REMOTE_ADDR' => '196.25.1.10',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0 Safari/537.36',
            'HTTP_CF_IPCOUNTRY' => 'ZA',
        ])->actingAs($admin)->get(route('admin.users.index'))->assertOk();

        $this->assertDatabaseHas('user_activities', [
            'user_id' => $admin->id,
            'activity_type' => 'visit',
            'route_name' => 'admin.users.index',
            'ip_address' => '196.25.1.10',
            'country_code' => 'ZA',
            'country_name' => 'South Africa',
            'browser' => 'Google Chrome',
            'platform' => 'Windows',
            'device_type' => 'Desktop',
        ]);
    }

    public function test_authenticated_session_only_records_one_visit_activity(): void
    {
        $this->seed();

        $admin = $this->superadmin();

        $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.reports.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.settings.edit'))->assertOk();

        $this->assertSame(
            1,
            UserActivity::query()
                ->where('user_id', $admin->id)
                ->where('activity_type', 'visit')
                ->count()
        );
    }

    public function test_successful_login_creates_a_login_activity_record(): void
    {
        $this->seed();

        $response = $this->withServerVariables([
            'REMOTE_ADDR' => '102.88.0.20',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile Safari/604.1',
            'HTTP_CF_IPCOUNTRY' => 'ZA',
        ])->post(route('login.store'), [
            'email' => 'admin@akhaniconnect.co.za',
            'password' => 'Akhaniconnect!1',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $admin = $this->superadmin();
        $activity = UserActivity::query()
            ->where('user_id', $admin->id)
            ->where('activity_type', 'login')
            ->latest('occurred_at')
            ->first();

        $this->assertNotNull($activity);
        $this->assertSame('South Africa', $activity->country_name);
        $this->assertSame('Safari', $activity->browser);
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

    public function test_unverified_candidate_sees_identity_verification_popup_on_shared_profile_page(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $response = $this->actingAs($candidate)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('You need to verify your ID to proceed.');
        $response->assertSee('Verify your ID');
        $response->assertSee('Verify ID To Continue');
    }

    public function test_unverified_candidate_cannot_update_shared_profile_until_identity_is_verified(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create([
            'email' => 'candidate-shared-profile@test.local',
            'phone' => '0823334444',
        ]);
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $response = $this->actingAs($candidate)->put(route('profile.update'), [
            'first_name' => 'Blocked',
            'surname' => 'Candidate',
            'email' => 'candidate-shared-profile@test.local',
            'phone' => '0823334444',
            'city' => 'Johannesburg',
            'province' => 'Gauteng',
        ]);

        $response->assertRedirect(route('candidate.identity-verification.show'));
        $response->assertSessionHas('error', 'You need to verify your ID to proceed.');
    }

    public function test_verified_candidate_sees_read_only_verified_id_number_on_shared_profile_page(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create([
            'country' => 'ZA',
            'id_number' => '9106011234087',
            'identity_verified' => true,
            'identity_verified_at' => now(),
        ]);
        $candidate->candidateProfile()->create();
        $candidate->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($candidate)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('This ID number was populated from your verified identity record.');
        $response->assertSee('readonly', false);
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
