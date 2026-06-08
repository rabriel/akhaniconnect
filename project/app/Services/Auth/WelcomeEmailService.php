<?php

namespace App\Services\Auth;

use App\Mail\WelcomeToAkhaniConnectMail;
use App\Models\User;
use App\Services\Admin\AdminSettingService;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailService
{
    public function __construct(
        protected AdminSettingService $adminSettingService
    ) {
    }

    /**
     * Send a welcome email to a newly created user.
     */
    public function send(User $user): void
    {
        $settings = $this->adminSettingService->getSettings();

        Mail::to($user->email)->send(
            new WelcomeToAkhaniConnectMail($user->loadMissing('role'), $settings)
        );
    }
}
