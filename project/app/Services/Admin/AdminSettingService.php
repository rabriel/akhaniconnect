<?php

namespace App\Services\Admin;

use App\Models\PlatformSetting;

class AdminSettingService
{
    /**
     * Get named platform settings with defaults.
     *
     * @return array<string, string>
     */
    public function getSettings(): array
    {
        $defaults = [
            'platform_name' => 'Akhani Connect',
            'support_email' => 'support@akhaniconnect.co.za',
            'default_country' => 'ZA',
            'registration_welcome_message' => 'Welcome to Akhani Connect',
        ];

        $stored = PlatformSetting::query()
            ->whereIn('key', array_keys($defaults))
            ->pluck('value', 'key')
            ->all();

        return array_merge($defaults, $stored);
    }

    /**
     * Persist platform settings.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): void
    {
        foreach ($data as $key => $value) {
            PlatformSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => (string) $value]
            );
        }
    }
}
