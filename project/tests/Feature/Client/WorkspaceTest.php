<?php

namespace Tests\Feature\Client;

use App\Models\User;
use App\Notifications\ProcurementRecordMessageNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
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

        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->procurementProfile()->create([
            'company_name' => 'Supplier Record',
            'registration_number' => '201408196207',
            'verification_progress' => 100,
        ]);
        $procurement->verificationRecords()->create([
            'module' => 'driver_licence',
            'provider' => 'verifynow',
            'status' => 'verified',
            'provider_reference' => 'driver-123',
            'last_verified_at' => now(),
        ]);

        $this->actingAs($client)
            ->get(route('client.procurement-records.show', $procurement))
            ->assertOk()
            ->assertSee('Supplier Record')
            ->assertSee('driver-123');
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
