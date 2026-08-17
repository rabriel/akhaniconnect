<?php

namespace App\Services\Privacy;

use App\Models\PrivacyAcknowledgement;
use App\Models\User;
use Illuminate\Http\Request;

class PrivacyAcknowledgementService
{
    public const SESSION_KEY = 'popia_acknowledged';

    private const NOTICE_VERSION = '2026-08-17';

    /**
     * Persist an acknowledgement and mark the current session as accepted.
     */
    public function acknowledge(User $user, Request $request): PrivacyAcknowledgement
    {
        $acknowledgement = $user->privacyAcknowledgements()->create([
            'privacy_notice_version' => $this->version(),
            'acknowledged_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $request->session()->put(self::SESSION_KEY, true);

        return $acknowledgement;
    }

    /**
     * Get the current privacy notice version identifier.
     */
    public function version(): string
    {
        return self::NOTICE_VERSION;
    }
}
