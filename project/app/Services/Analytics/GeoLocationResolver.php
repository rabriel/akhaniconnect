<?php

namespace App\Services\Analytics;

class GeoLocationResolver
{
    /**
     * Resolve country details from request headers or IP heuristics.
     *
     * @param  array<string, string|null>  $headers
     * @return array{country_code: ?string, country_name: ?string}
     */
    public function resolve(?string $ipAddress, array $headers = []): array
    {
        $headerCountryCode = $this->firstFilled([
            $headers['CF-IPCountry'] ?? null,
            $headers['X-Appengine-Country'] ?? null,
            $headers['X-Country-Code'] ?? null,
        ]);

        if ($headerCountryCode !== null) {
            $normalizedCode = strtoupper(substr($headerCountryCode, 0, 2));

            return [
                'country_code' => $normalizedCode,
                'country_name' => $this->countryName($normalizedCode),
            ];
        }

        if ($ipAddress !== null && $this->isPrivateIp($ipAddress)) {
            return [
                'country_code' => 'LN',
                'country_name' => 'Local Network',
            ];
        }

        return [
            'country_code' => null,
            'country_name' => 'Unknown',
        ];
    }

    protected function firstFilled(array $values): ?string
    {
        foreach ($values as $value) {
            if (filled($value)) {
                return (string) $value;
            }
        }

        return null;
    }

    protected function isPrivateIp(string $ipAddress): bool
    {
        return filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    protected function countryName(string $countryCode): string
    {
        return [
            'ZA' => 'South Africa',
            'US' => 'United States',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'CA' => 'Canada',
            'IN' => 'India',
            'DE' => 'Germany',
            'FR' => 'France',
            'NL' => 'Netherlands',
            'LN' => 'Local Network',
        ][$countryCode] ?? $countryCode;
    }
}
