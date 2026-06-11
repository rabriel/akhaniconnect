<?php

namespace App\Services\Analytics;

class UserAgentParser
{
    /**
     * Parse a user agent string into browser, platform, and device details.
     *
     * @return array<string, string>
     */
    public function parse(?string $userAgent): array
    {
        $userAgent = (string) $userAgent;

        return [
            'browser' => $this->resolveBrowser($userAgent),
            'platform' => $this->resolvePlatform($userAgent),
            'device_type' => $this->resolveDeviceType($userAgent),
        ];
    }

    protected function resolveBrowser(string $userAgent): string
    {
        return match (true) {
            str_contains($userAgent, 'Edg/') => 'Microsoft Edge',
            str_contains($userAgent, 'OPR/') || str_contains($userAgent, 'Opera') => 'Opera',
            str_contains($userAgent, 'Chrome/') => 'Google Chrome',
            str_contains($userAgent, 'Firefox/') => 'Mozilla Firefox',
            str_contains($userAgent, 'Safari/') && ! str_contains($userAgent, 'Chrome/') => 'Safari',
            str_contains($userAgent, 'PostmanRuntime/') => 'Postman',
            str_contains($userAgent, 'Symfony') => 'Symfony BrowserKit',
            default => 'Unknown Browser',
        };
    }

    protected function resolvePlatform(string $userAgent): string
    {
        return match (true) {
            str_contains($userAgent, 'Windows') => 'Windows',
            str_contains($userAgent, 'Macintosh') || str_contains($userAgent, 'Mac OS X') => 'macOS',
            str_contains($userAgent, 'Android') => 'Android',
            str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad') => 'iOS',
            str_contains($userAgent, 'Linux') => 'Linux',
            default => 'Unknown Platform',
        };
    }

    protected function resolveDeviceType(string $userAgent): string
    {
        return match (true) {
            preg_match('/bot|crawl|spider|slurp/i', $userAgent) === 1 => 'Bot',
            preg_match('/ipad|tablet/i', $userAgent) === 1 => 'Tablet',
            preg_match('/mobile|iphone|android/i', $userAgent) === 1 => 'Mobile',
            $userAgent !== '' => 'Desktop',
            default => 'Unknown Device',
        };
    }
}
