<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use App\Notifications\ProcurementRecordMessageNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InboxTest extends TestCase
{
    use RefreshDatabase;

    public function test_procurement_user_can_view_and_mark_notifications_as_read(): void
    {
        $this->seed();

        $client = User::factory()->withRole(5)->create([
            'first_name' => 'Client',
            'surname' => 'Sender',
        ]);
        $procurement = User::factory()->withRole(4)->create();
        $procurement->profile()->create(['country' => 'ZA']);
        $procurement->notify(new ProcurementRecordMessageNotification(
            $client,
            'Verification follow-up',
            'Please complete the outstanding verification steps.'
        ));

        $notification = $procurement->notifications()->firstOrFail();

        $this->actingAs($procurement)
            ->get(route('notifications.index'))
            ->assertOk()
            ->assertSee('Verification follow-up');

        $this->actingAs($procurement)
            ->put(route('notifications.update', $notification->id))
            ->assertRedirect(route('notifications.index'))
            ->assertSessionHas('status');

        $this->assertNotNull($notification->fresh()->read_at);
    }
}
