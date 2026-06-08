<?php

namespace App\Services\Client;

use App\Models\User;
use App\Notifications\ProcurementRecordMessageNotification;

class ClientNotificationService
{
    /**
     * Send a client message to a procurement user.
     *
     * @param  array<string, mixed>  $data
     */
    public function sendProcurementMessage(User $client, User $procurementUser, array $data): void
    {
        $procurementUser->notify(new ProcurementRecordMessageNotification(
            $client,
            (string) $data['subject'],
            (string) $data['message'],
        ));
    }
}
