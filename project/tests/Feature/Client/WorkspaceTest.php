<?php

namespace Tests\Feature\Client;

use App\Models\User;
use App\Notifications\ProcurementRecordMessageNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_user_can_view_client_dashboard_and_procurement_records(): void
    {
        $this->seed();

        $client = User::factory()->withRole(5)->create();
        $client->profile()->create(['country' => 'ZA']);
        $client->clientProfile()->create(['company_name' => 'Akhani Client']);

        $procurement = User::factory()->withRole(4)->create([
            'first_name' => 'Nomsa',
            'surname' => 'Supplier',
        ]);
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->procurementProfile()->create([
            'company_name' => 'Nomsa Trading',
            'registration_number' => '201408196207',
            'verification_progress' => 66,
        ]);

        $this->actingAs($client)
            ->get(route('client.dashboard'))
            ->assertOk()
            ->assertSee('Client Dashboard');

        $this->actingAs($client)
            ->get(route('client.procurement-records.index'))
            ->assertOk()
            ->assertSee('Procurement Records')
            ->assertSee('Nomsa Trading');
    }

    public function test_client_can_filter_procurement_records(): void
    {
        $this->seed();

        $client = User::factory()->withRole(5)->create();
        $client->profile()->create(['country' => 'ZA']);
        $client->clientProfile()->create();

        $verified = User::factory()->withRole(4)->create();
        $verified->procurementProfile()->create([
            'company_name' => 'Verified Supplier',
            'verification_progress' => 100,
        ]);
        $verified->verificationRecords()->create([
            'module' => 'bank_account',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $pending = User::factory()->withRole(4)->create();
        $pending->procurementProfile()->create([
            'company_name' => 'Pending Supplier',
            'verification_progress' => 0,
        ]);

        $this->actingAs($client)
            ->get(route('client.procurement-records.index', [
                'search' => 'Verified',
                'progress' => 'verified',
                'module' => 'bank_account',
            ]))
            ->assertOk()
            ->assertSee('Verified Supplier')
            ->assertDontSee('Pending Supplier');
    }

    public function test_client_can_view_procurement_record_detail(): void
    {
        $this->seed();

        $client = User::factory()->withRole(5)->create();
        $client->profile()->create(['country' => 'ZA']);
        $client->clientProfile()->create();

        $procurement = User::factory()->withRole(4)->create([
            'first_name' => 'Lerato',
            'surname' => 'Mabena',
            'phone' => '0820000044',
        ]);
        $procurement->profile()->create([
            'country' => 'ZA',
            'id_number' => '8905155324082',
            'gender' => 'Female',
            'city' => 'Johannesburg',
        ]);
        $profile = $procurement->procurementProfile()->create([
            'company_name' => 'Supplier Record',
            'registration_number' => '201408196207',
            'enterprise_type' => 'Private Company',
            'enterprise_status' => 'In Business',
            'company_phone' => '0315550101',
            'verification_progress' => 100,
        ]);
        $procurement->verificationRecords()->create([
            'module' => 'enterprise',
            'provider' => 'verifynow',
            'status' => 'verified',
            'provider_reference' => 'enterprise-123',
            'last_verified_at' => now(),
            'summary' => [
                'transaction_id' => 'txn-123',
                'status' => 'verified',
            ],
        ]);
        $profile->directors()->create([
            'full_name' => 'John Doe',
            'id_number' => '8001015009087',
            'initials' => 'JD',
            'gender' => 'Male',
            'title' => 'Mister',
            'marital_status' => 'Single',
            'privacy_status' => 'ACCEPTS CONTRACTS',
            'cellular_number' => '0825550100',
            'email_address' => 'john@example.co.za',
            'employer' => 'EXAMPLE COMPANY PTY LTD',
            'number_of_enquiries' => 2,
            'status' => 'verified',
            'director_status' => 'Success',
        ]);
        $procurement->documents()->create([
            'category' => 'procurement_profile',
            'type' => 'supporting_document',
            'display_name' => 'BBBEE Certificate',
            'original_name' => 'bbbee-certificate.pdf',
            'path' => 'documents/procurement_profile/bbbee-certificate.pdf',
            'mime_type' => 'application/pdf',
            'size' => 1024,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);

        $this->actingAs($client)
            ->get(route('client.procurement-records.show', $procurement))
            ->assertOk()
            ->assertSee('Verified Procurement Information')
            ->assertSee('Supplier Record')
            ->assertSee('Enterprise Details')
            ->assertSee('John Doe')
            ->assertSee('Procurement Documents')
            ->assertSee('BBBEE Certificate')
            ->assertSee('enterprise-123');
    }

    public function test_client_can_download_procurement_report(): void
    {
        $this->seed();

        $client = User::factory()->withRole(5)->create();
        $client->profile()->create(['country' => 'ZA']);
        $client->clientProfile()->create();

        $procurement = User::factory()->withRole(4)->create([
            'first_name' => 'Nomsa',
            'surname' => 'Supplier',
        ]);
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->procurementProfile()->create([
            'company_name' => 'Supplier Record',
            'registration_number' => '201408196207',
            'verification_progress' => 100,
        ]);

        $response = $this->actingAs($client)->get(route('client.procurement-records.report', $procurement));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_client_can_download_enterprise_report(): void
    {
        $this->seed();

        $client = User::factory()->withRole(5)->create();
        $client->profile()->create(['country' => 'ZA']);
        $client->clientProfile()->create();

        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->procurementProfile()->create([
            'company_name' => 'Supplier Record',
            'registration_number' => '201408196207',
            'verification_progress' => 100,
        ]);

        $response = $this->actingAs($client)->get(route('client.procurement-records.enterprise-report', $procurement));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_client_can_download_director_report(): void
    {
        $this->seed();

        $client = User::factory()->withRole(5)->create();
        $client->profile()->create(['country' => 'ZA']);
        $client->clientProfile()->create();

        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $profile = $procurement->procurementProfile()->create([
            'company_name' => 'Supplier Record',
            'registration_number' => '201408196207',
            'verification_progress' => 100,
        ]);
        $director = $profile->directors()->create([
            'full_name' => 'Jane Director',
            'id_number' => '8001015009087',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($client)->get(route('client.procurement-records.director-report', [$procurement, $director]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_client_can_download_procurement_supporting_document(): void
    {
        $this->seed();
        Storage::fake('public');

        $client = User::factory()->withRole(5)->create();
        $client->profile()->create(['country' => 'ZA']);
        $client->clientProfile()->create();

        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->procurementProfile()->create([
            'company_name' => 'Supplier Record',
            'registration_number' => '201408196207',
            'verification_progress' => 100,
        ]);

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

        $response = $this->actingAs($client)->get(route('client.procurement-records.documents.show', [$procurement, $document]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_client_can_send_notification_to_procurement_user(): void
    {
        $this->seed();
        Notification::fake();

        $client = User::factory()->withRole(5)->create();
        $client->profile()->create(['country' => 'ZA']);
        $client->clientProfile()->create();

        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->procurementProfile()->create();

        $response = $this->actingAs($client)->post(route('client.procurement-records.notify', $procurement), [
            'subject' => 'Outstanding verification item',
            'message' => 'Please review and complete the remaining verification steps for client review.',
        ]);

        $response->assertRedirect(route('client.procurement-records.show', $procurement));
        $response->assertSessionHas('status');

        Notification::assertSentTo($procurement, ProcurementRecordMessageNotification::class);
    }

    public function test_candidate_cannot_access_client_procurement_records(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $this->actingAs($candidate)
            ->get(route('client.procurement-records.index'))
            ->assertForbidden();
    }
}
