<?php

namespace Tests\Unit;

use App\Services\Verification\VerifyNowClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class VerifyNowClientTest extends TestCase
{
    public function test_verify_south_african_id_uses_expected_endpoint_and_payload(): void
    {
        Http::fake([
            '*' => Http::response(['success' => true], 200),
        ]);

        config([
            'verifynow.base_url' => 'https://www.verifynow.co.za/api/external',
            'verifynow.mode' => 'sandbox',
            'verifynow.api_key' => 'test-key',
        ]);

        $client = app(VerifyNowClient::class);
        $client->verifySouthAfricanId('9106011234087');

        Http::assertSent(function ($request): bool {
            return $request->url() === 'https://www.verifynow.co.za/api/external/verify'
                && $request['reportType'] === 'said_verification'
                && $request['idNumber'] === '9106011234087'
                && $request['mode'] === 'sandbox'
                && $request->hasHeader('x-api-key', 'test-key');
        });
    }

    public function test_verify_enterprise_uses_expected_endpoint_and_payload(): void
    {
        Http::fake([
            '*' => Http::response(['success' => true], 200),
        ]);

        config([
            'verifynow.base_url' => 'https://www.verifynow.co.za/api/external',
            'verifynow.mode' => 'sandbox',
            'verifynow.api_key' => 'test-key',
        ]);

        $client = app(VerifyNowClient::class);
        $client->verifyEnterprise([
            'registration_number' => '201408196207',
        ]);

        Http::assertSent(function ($request): bool {
            return $request->url() === 'https://www.verifynow.co.za/api/external/cipc'
                && $request['reportType'] === 'cipc_company_match'
                && $request['registration_number'] === '201408196207'
                && $request['mode'] === 'sandbox';
        });
    }

    public function test_verify_enterprise_director_uses_expected_endpoint_and_payload(): void
    {
        Http::fake([
            '*' => Http::response(['success' => true], 200),
        ]);

        config([
            'verifynow.base_url' => 'https://www.verifynow.co.za/api/external',
            'verifynow.mode' => 'sandbox',
            'verifynow.api_key' => 'test-key',
        ]);

        $client = app(VerifyNowClient::class);
        $client->verifyEnterpriseDirector('8905155324082');

        Http::assertSent(function ($request): bool {
            return $request->url() === 'https://www.verifynow.co.za/api/external/cipc'
                && $request['reportType'] === 'cipc_director_search'
                && $request['idNumber'] === '8905155324082'
                && $request['mode'] === 'sandbox';
        });
    }
}
