<?php

namespace App\Services\Verification;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class VerifyNowClient
{
    /**
     * Submit a South African ID verification request.
     */
    public function verifySouthAfricanId(string $idNumber): Response
    {
        return Http::baseUrl(config('verifynow.base_url'))
            ->timeout((int) config('verifynow.timeout', 30))
            ->withHeaders($this->buildHeaders())
            ->post('/verify', [
                'reportType' => 'said_verification',
                'idNumber' => $idNumber,
                'mode' => config('verifynow.mode', 'sandbox'),
            ]);
    }

    /**
     * Submit a CIPC company verification request.
     *
     * @param  array<string, mixed>  $payload
     */
    public function verifyEnterprise(array $payload): Response
    {
        return Http::baseUrl(config('verifynow.base_url'))
            ->timeout((int) config('verifynow.timeout', 30))
            ->withHeaders($this->buildHeaders())
            ->post('/cipc', array_merge($payload, [
                'reportType' => 'cipc_company_match',
                'mode' => config('verifynow.mode', 'sandbox'),
            ]));
    }

    /**
     * Submit a CIPC director search request.
     */
    public function verifyEnterpriseDirector(string $idNumber): Response
    {
        return Http::baseUrl(config('verifynow.base_url'))
            ->timeout((int) config('verifynow.timeout', 30))
            ->withHeaders($this->buildHeaders())
            ->post('/cipc', [
                'reportType' => 'cipc_director_search',
                'idNumber' => $idNumber,
                'mode' => config('verifynow.mode', 'sandbox'),
            ]);
    }

    /**
     * Submit a bank account verification request.
     *
     * @param  array<string, mixed>  $payload
     */
    public function verifyBankAccount(array $payload): Response
    {
        return Http::baseUrl(config('verifynow.base_url'))
            ->timeout((int) config('verifynow.timeout', 30))
            ->withHeaders($this->buildHeaders())
            ->post('/bank-account-verification', array_merge($payload, [
                'mode' => config('verifynow.mode', 'sandbox'),
            ]));
    }

    /**
     * Submit a driver licence OCR verification request.
     */
    public function verifyDriverLicence(UploadedFile $frontImage, ?UploadedFile $backImage = null): Response
    {
        $request = Http::baseUrl(config('verifynow.base_url'))
            ->timeout((int) config('verifynow.timeout', 30))
            ->withHeaders($this->buildHeaders())
            ->attach(
                'front_image',
                file_get_contents($frontImage->getRealPath()),
                $frontImage->getClientOriginalName()
            );

        if ($backImage !== null) {
            $request = $request->attach(
                'back_image',
                file_get_contents($backImage->getRealPath()),
                $backImage->getClientOriginalName()
            );
        }

        return $request->post('/id-document-verify', [
            'bundle' => 'id_document_verification',
            'document_type' => 'drivers_license',
            'issuing_country' => 'ZAF',
            'mode' => config('verifynow.mode', 'sandbox'),
        ]);
    }

    /**
     * Submit a driver licence OCR verification request from stored files.
     */
    public function verifyDriverLicenceFromStoredPaths(string $frontPath, ?string $backPath = null): Response
    {
        $request = Http::baseUrl(config('verifynow.base_url'))
            ->timeout((int) config('verifynow.timeout', 30))
            ->withHeaders($this->buildHeaders())
            ->attach(
                'front_image',
                file_get_contents(Storage::disk('public')->path($frontPath)),
                basename($frontPath)
            );

        if ($backPath !== null && Storage::disk('public')->exists($backPath)) {
            $request = $request->attach(
                'back_image',
                file_get_contents(Storage::disk('public')->path($backPath)),
                basename($backPath)
            );
        }

        return $request->post('/id-document-verify', [
            'bundle' => 'id_document_verification',
            'document_type' => 'drivers_license',
            'issuing_country' => 'ZAF',
            'mode' => config('verifynow.mode', 'sandbox'),
        ]);
    }

    /**
     * Build shared request headers.
     *
     * @return array<string, string>
     */
    protected function buildHeaders(): array
    {
        return [
            'x-api-key' => (string) config('verifynow.api_key'),
            'Idempotency-Key' => (string) Str::uuid(),
        ];
    }
}
