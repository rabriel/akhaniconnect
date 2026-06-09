<?php

namespace Tests\Feature\Procurement;

use App\Models\User;
use App\Models\VerificationRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OnboardingTest extends TestCase
{
    use RefreshDatabase;

    public function test_procurement_user_can_view_procurement_dashboard_and_pages(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create([
            'country' => 'ZA',
            'id_number' => '9106011234087',
            'identity_verified' => true,
            'identity_verified_at' => now(),
        ]);
        $user->procurementProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $this->actingAs($user)
            ->get(route('procurement.dashboard'))
            ->assertOk()
            ->assertSee('Procurement Dashboard');

        $this->actingAs($user)
            ->get(route('procurement.identity-verification.show'))
            ->assertOk()
            ->assertSee('SA ID Verification');

        $this->actingAs($user)
            ->get(route('procurement.profile.edit'))
            ->assertOk()
            ->assertSee('Personal Details');

        $this->actingAs($user)
            ->get(route('procurement.enterprise.edit'))
            ->assertOk()
            ->assertSee('CIPC Enterprise');

        $this->actingAs($user)
            ->get(route('procurement.directors.index'))
            ->assertOk()
            ->assertSee('Add Director');

        $this->actingAs($user)
            ->get(route('procurement.documents.index'))
            ->assertOk()
            ->assertSee('Procurement Documents');

        $this->actingAs($user)
            ->get(route('procurement.documents.proof-of-address'))
            ->assertOk()
            ->assertSee('Upload Document');

        $this->actingAs($user)
            ->get(route('procurement.verifications.driver-licence'))
            ->assertOk()
            ->assertSee('Driver Licence Verification');

        $this->actingAs($user)
            ->get(route('procurement.verifications.bank-account'))
            ->assertOk()
            ->assertSee('Bank Account Verification');

        $this->actingAs($user)
            ->get(route('procurement.verifications.history'))
            ->assertOk()
            ->assertSee('Saved Verification Records');
    }

    public function test_procurement_user_can_update_personal_details(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create([
            'email' => 'procurement-onboarding@test.local',
            'phone' => '0825550001',
        ]);
        $user->profile()->create([
            'country' => 'ZA',
            'id_number' => '9106011234087',
            'identity_verified' => true,
            'identity_verified_at' => now(),
        ]);
        $user->procurementProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->put(route('procurement.profile.update'), [
            'first_name' => 'Gabriel',
            'surname' => 'Procurement',
            'email' => 'procurement-onboarding@test.local',
            'phone' => '0825550001',
            'date_of_birth' => '1991-06-01',
            'gender' => 'Male',
            'id_number' => '9106011234087',
            'passport_number' => '',
            'address_line_1' => '14 Oak Avenue',
            'address_line_2' => '',
            'suburb' => 'Sandton',
            'city' => 'Johannesburg',
            'province' => 'Gauteng',
            'postal_code' => '2196',
        ]);

        $response->assertRedirect(route('procurement.profile.edit'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'id_number' => '9106011234087',
            'profile_completed' => 1,
            'city' => 'Johannesburg',
        ]);
    }

    public function test_procurement_user_can_update_enterprise_details_and_progress(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create([
            'country' => 'ZA',
            'id_number' => '9001011234088',
            'profile_completed' => true,
        ]);
        $user->procurementProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->put(route('procurement.enterprise.update'), [
            'registration_number' => '201408196207',
        ]);

        $response->assertRedirect(route('procurement.enterprise.edit'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('procurement_profiles', [
            'user_id' => $user->id,
            'registration_number' => '201408196207',
            'verification_progress' => 50,
        ]);
    }

    public function test_candidate_cannot_access_procurement_onboarding_pages(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);

        $this->actingAs($candidate)
            ->get(route('procurement.profile.edit'))
            ->assertForbidden();
    }

    public function test_procurement_user_can_add_directors(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->post(route('procurement.directors.store'), [
            'id_number' => '8201011234080',
        ]);

        $response->assertRedirect(route('procurement.directors.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('procurement_directors', [
            'id_number' => '8201011234080',
            'full_name' => 'Pending verification',
            'status' => 'saved',
        ]);
    }

    public function test_procurement_user_can_upload_proof_of_address_document(): void
    {
        $this->seed();
        Storage::fake('public');

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->post(route('procurement.documents.proof-of-address.store'), [
            'document' => UploadedFile::fake()->create('proof-of-address.pdf', 400, 'application/pdf'),
        ]);

        $response->assertRedirect(route('procurement.documents.proof-of-address'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('documents', [
            'user_id' => $user->id,
            'category' => 'proof_of_address',
            'status' => 'uploaded',
        ]);
    }

    public function test_procurement_user_can_upload_named_supporting_documents(): void
    {
        $this->seed();
        Storage::fake('public');

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->post(route('procurement.documents.store'), [
            'documents' => [
                [
                    'name' => 'BBBEE Certificate',
                    'file' => UploadedFile::fake()->create('bbbee.pdf', 300, 'application/pdf'),
                ],
                [
                    'name' => 'Tax Clearance',
                    'file' => UploadedFile::fake()->create('tax-clearance.pdf', 300, 'application/pdf'),
                ],
            ],
        ]);

        $response->assertRedirect(route('procurement.documents.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('documents', [
            'user_id' => $user->id,
            'category' => 'procurement_profile',
            'display_name' => 'BBBEE Certificate',
            'status' => 'uploaded',
        ]);

        $this->assertDatabaseHas('documents', [
            'user_id' => $user->id,
            'category' => 'procurement_profile',
            'display_name' => 'Tax Clearance',
            'status' => 'uploaded',
        ]);
    }

    public function test_procurement_user_can_submit_driver_licence_verification(): void
    {
        $this->seed();
        Storage::fake('public');
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'requestId' => 'driver-ref-123',
                'mode' => 'sandbox',
                'results' => [
                    'id_document_verification' => [
                        'Status' => 'Success',
                    ],
                ],
            ], 200),
        ]);

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->post(route('procurement.verifications.driver-licence.store'), [
            'front_image' => UploadedFile::fake()->image('driver-front.jpg'),
            'back_image' => UploadedFile::fake()->image('driver-back.jpg'),
        ]);

        $response->assertRedirect(route('procurement.verifications.driver-licence'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('verification_records', [
            'user_id' => $user->id,
            'module' => 'driver_licence',
            'status' => 'verified',
        ]);

        $this->assertDatabaseHas('verification_attempts', [
            'status' => 'verified',
            'provider_reference' => 'driver-ref-123',
        ]);
    }

    public function test_procurement_user_can_submit_bank_account_verification(): void
    {
        $this->seed();
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'requestId' => 'bank-ref-456',
                'mode' => 'sandbox',
            ], 200),
        ]);

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create([
            'country' => 'ZA',
            'id_number' => '9001011234088',
        ]);
        $user->procurementProfile()->create([
            'company_name' => 'Akhani Procurement',
            'registration_number' => '201408196207',
        ]);
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->post(route('procurement.verifications.bank-account.store'), [
            'type' => 'Company',
            'first_name' => '',
            'surname' => 'Akhani Procurement',
            'identity_number' => '201408196207',
            'identity_type' => 'CompanyRegNumber',
            'bank_account_number' => '62142892604',
            'bank_branch_code' => '250741',
            'bank_account_type' => 'Current',
        ]);

        $response->assertRedirect(route('procurement.verifications.bank-account'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('verification_records', [
            'user_id' => $user->id,
            'module' => 'bank_account',
            'status' => 'verified',
        ]);

        $this->assertDatabaseHas('verification_attempts', [
            'status' => 'verified',
            'provider_reference' => 'bank-ref-456',
        ]);
    }

    public function test_procurement_user_can_view_verification_record_history(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);
        $record = $user->verificationRecords()->create([
            'module' => 'bank_account',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);
        $record->attempts()->create([
            'status' => 'verified',
            'provider_reference' => 'history-ref-1',
            'request_payload' => ['type' => 'Company'],
            'processed_response' => ['success' => true],
            'attempted_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('procurement.verifications.show', $record));

        $response->assertOk();
        $response->assertSee('Verification Record');
        $response->assertSee('history-ref-1');
    }

    public function test_procurement_user_can_retry_bank_account_verification_from_history(): void
    {
        $this->seed();
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'requestId' => 'retry-bank-789',
                'mode' => 'sandbox',
            ], 200),
        ]);

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create([
            'country' => 'ZA',
            'id_number' => '9001011234088',
            'identity_verified' => true,
            'identity_verified_at' => now(),
        ]);
        $user->procurementProfile()->create([
            'company_name' => 'Retry Company',
            'registration_number' => '201408196207',
        ]);
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);
        $record = $user->verificationRecords()->create([
            'module' => 'bank_account',
            'provider' => 'verifynow',
            'status' => 'failed',
        ]);
        $record->attempts()->create([
            'status' => 'failed',
            'request_payload' => [
                'type' => 'Company',
                'first_name' => '',
                'surname' => 'Retry Company',
                'identity_number' => '201408196207',
                'identity_type' => 'CompanyRegNumber',
                'bank_account_number' => '62142892604',
                'bank_branch_code' => '250741',
                'bank_account_type' => 'Current',
            ],
            'attempted_at' => now()->subMinute(),
        ]);

        $response = $this->actingAs($user)->post(route('procurement.verifications.retry', $record));

        $response->assertRedirect(route('procurement.verifications.show', $record));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('verification_records', [
            'id' => $record->id,
            'status' => 'verified',
            'provider_reference' => 'retry-bank-789',
        ]);
    }

    public function test_procurement_dashboard_redirects_to_identity_verification_when_identity_is_not_verified(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create();

        $this->actingAs($user)
            ->get(route('procurement.dashboard'))
            ->assertRedirect(route('procurement.identity-verification.show'));
    }

    public function test_unverified_procurement_user_cannot_access_procurement_actions(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create([
            'email' => 'procurement-lockout@test.local',
            'phone' => '0827771111',
        ]);
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create();

        $this->actingAs($user)
            ->get(route('procurement.profile.edit'))
            ->assertRedirect(route('procurement.identity-verification.show'));

        $updateResponse = $this->actingAs($user)->put(route('procurement.profile.update'), [
            'first_name' => 'Locked',
            'surname' => 'Procurement',
            'email' => 'procurement-lockout@test.local',
            'phone' => '0827771111',
            'date_of_birth' => '1991-06-01',
            'gender' => 'Male',
            'id_number' => '9106011234087',
            'address_line_1' => '14 Oak Avenue',
            'suburb' => 'Sandton',
            'city' => 'Johannesburg',
            'province' => 'Gauteng',
            'postal_code' => '2196',
        ]);

        $updateResponse->assertRedirect(route('procurement.identity-verification.show'));
        $updateResponse->assertSessionHas('error', 'You need to verify your ID to proceed.');
    }

    public function test_procurement_user_can_submit_sa_id_verification(): void
    {
        $this->seed();
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'requestId' => 'said-ref-999',
                'reportType' => 'said_verification',
                'mode' => 'sandbox',
                'results' => [
                    'said_verification' => [
                        'transaction_id' => 'txn-99',
                        'realTimeResults' => [
                            'Status' => 'ID Number Valid',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create();

        $response = $this->actingAs($user)->post(route('procurement.identity-verification.store'), [
            'id_number' => '9106011234087',
        ]);

        $response->assertRedirect(route('procurement.identity-verification.show'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('verification_records', [
            'user_id' => $user->id,
            'module' => 'sa_identity',
            'status' => 'verified',
            'provider_reference' => 'said-ref-999',
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'id_number' => '9106011234087',
            'identity_verified' => 1,
        ]);
    }

    public function test_procurement_user_can_submit_enterprise_verification(): void
    {
        $this->seed();
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'requestId' => 'cipc-ref-123',
                'mode' => 'sandbox',
                'results' => [
                    'cipc_company_match' => [
                        'Status' => 'Success',
                        'transaction_id' => 'cipc-txn-1',
                        'company_name' => 'Akhani Procurement',
                        'registration_number' => '201408196207',
                        'vat_number' => '4123456789',
                        'telephone' => '0115551234',
                        'company_type' => 'Private Company',
                        'registered_address' => '1 Main Road, Sandton, Johannesburg',
                    ],
                ],
            ], 200),
        ]);

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create([
            'registration_number' => '201408196207',
        ]);
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->post(route('procurement.enterprise.verify'));

        $response->assertRedirect(route('procurement.enterprise.edit'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('verification_records', [
            'user_id' => $user->id,
            'module' => 'enterprise',
            'status' => 'verified',
            'provider_reference' => 'cipc-ref-123',
        ]);

        $this->assertDatabaseHas('procurement_profiles', [
            'user_id' => $user->id,
            'company_name' => 'Akhani Procurement',
            'registration_number' => '201408196207',
            'vat_number' => '4123456789',
            'company_phone' => '0115551234',
            'enterprise_status' => 'Success',
            'enterprise_type' => 'Private Company',
            'enterprise_address' => '1 Main Road, Sandton, Johannesburg',
        ]);

        $reportResponse = $this->actingAs($user)->get(route('procurement.enterprise.report'));
        $reportResponse->assertOk();
        $reportResponse->assertHeader('content-type', 'application/pdf');
    }

    public function test_procurement_user_can_submit_enterprise_director_verification(): void
    {
        $this->seed();
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'requestId' => 'director-ref-321',
                'mode' => 'sandbox',
                'results' => [
                    'cipc_director_search' => [
                        'Status' => 'Success',
                        'transaction_id' => 'dir-txn-1',
                        'director_name' => 'Nomsa Dlamini',
                        'director_position' => 'Director',
                        'companies' => [
                            ['registration_number' => '201408196207'],
                        ],
                    ],
                ],
                'full_name' => 'Nomsa Dlamini',
                'id_number' => '8905155324082',
                'initials' => 'ND',
                'birth_date' => '1980-01-01',
                'gender' => 'Female',
                'title' => 'Ms',
                'marital_status' => 'Single',
                'privacy_status' => 'ACCEPTS CONTRACTS',
                'cellular_number' => '0825550100',
                'home_telephone' => '0115550100',
                'work_telephone' => '0115550101',
                'email_address' => 'nomsa@example.co.za',
                'residential_address' => '1 Example Street, Johannesburg, 2000',
                'postal_address' => 'PO Box 123, Johannesburg, 2000',
                'employer' => 'EXAMPLE COMPANY PTY LTD',
                'number_of_enquiries' => '2',
            ], 200),
        ]);

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $profile = $user->procurementProfile()->create([
            'company_name' => 'Akhani Procurement',
            'registration_number' => '201408196207',
        ]);
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);
        $director = $profile->directors()->create([
            'full_name' => 'Pending verification',
            'id_number' => '8905155324082',
            'status' => 'saved',
        ]);

        $response = $this->actingAs($user)->post(route('procurement.directors.verify', $director));

        $response->assertRedirect(route('procurement.directors.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('verification_records', [
            'user_id' => $user->id,
            'module' => 'enterprise_director',
            'status' => 'verified',
            'provider_reference' => 'director-ref-321',
            'verifiable_type' => 'App\\Models\\ProcurementDirector',
            'verifiable_id' => $director->id,
        ]);

        $this->assertDatabaseHas('procurement_directors', [
            'id' => $director->id,
            'full_name' => 'Nomsa Dlamini',
            'initials' => 'ND',
            'gender' => 'Female',
            'email_address' => 'nomsa@example.co.za',
            'employer' => 'EXAMPLE COMPANY PTY LTD',
            'number_of_enquiries' => 2,
            'position' => 'Director',
            'status' => 'verified',
            'director_status' => 'Success',
            'provider_reference' => 'director-ref-321',
        ]);

        $this->assertDatabaseHas('procurement_directors', [
            'id' => $director->id,
            'residential_address' => '1 Example Street, Johannesburg, 2000',
            'postal_address' => 'PO Box 123, Johannesburg, 2000',
        ]);

        $viewResponse = $this->actingAs($user)->get(route('procurement.directors.show', $director));
        $viewResponse->assertOk();
        $viewResponse->assertSee('Nomsa Dlamini');
        $viewResponse->assertSee('nomsa@example.co.za');

        $reportResponse = $this->actingAs($user)->get(route('procurement.directors.report', $director));
        $reportResponse->assertOk();
        $reportResponse->assertHeader('content-type', 'application/pdf');
    }
}
