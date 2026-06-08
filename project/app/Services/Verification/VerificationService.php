<?php

namespace App\Services\Verification;

use App\Models\ProcurementDirector;
use App\Models\ProcurementProfile;
use App\Models\User;
use App\Models\VerificationAttempt;
use App\Models\VerificationRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile as HttpUploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class VerificationService
{
    public function __construct(
        protected VerifyNowClient $verifyNowClient,
    ) {
    }

    /**
     * Submit a South African ID verification and persist its history.
     */
    public function verifySouthAfricanId(User $user, string $idNumber): VerificationRecord
    {
        $record = $this->getRecord($user, 'sa_identity');

        $requestPayload = [
            'id_number' => $idNumber,
            'reportType' => 'said_verification',
            'mode' => config('verifynow.mode', 'sandbox'),
        ];

        try {
            $response = $this->verifyNowClient->verifySouthAfricanId($idNumber);

            return $this->storeResult(
                $record,
                $requestPayload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractSouthAfricanIdSummary($response->json() ?? [])
            );
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $requestPayload, $exception->getMessage());
        }
    }

    /**
     * Submit an enterprise verification and persist its history.
     */
    public function verifyEnterprise(User $user): VerificationRecord
    {
        $profile = $user->procurementProfile()->firstOrCreate(['user_id' => $user->id]);
        $record = $this->getRecord($user, 'enterprise', $profile);

        $requestPayload = [
            'registration_number' => $profile->registration_number,
            'reportType' => 'cipc_company_match',
            'mode' => config('verifynow.mode', 'sandbox'),
        ];

        try {
            $response = $this->verifyNowClient->verifyEnterprise([
                'registration_number' => $profile->registration_number,
            ]);

            $record = $this->storeResult(
                $record,
                $requestPayload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractEnterpriseSummary($response->json() ?? [])
            );

            if ($record->status === 'verified') {
                $this->syncEnterpriseProfile($profile, $response->json() ?? []);
            }

            return $record;
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $requestPayload, $exception->getMessage());
        }
    }

    /**
     * Submit an enterprise director verification and persist its history.
     */
    public function verifyEnterpriseDirector(User $user, ProcurementDirector $director): VerificationRecord
    {
        $record = $this->getRecord($user, 'enterprise_director', $director);
        $requestPayload = [
            'director_id' => $director->id,
            'id_number' => $director->id_number,
            'reportType' => 'cipc_director_search',
            'mode' => config('verifynow.mode', 'sandbox'),
        ];

        try {
            $response = $this->verifyNowClient->verifyEnterpriseDirector($director->id_number);

            $record = $this->storeResult(
                $record,
                $requestPayload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractEnterpriseDirectorSummary($response->json() ?? [], $director)
            );

            $director->update([
                'full_name' => $record->summary['director_name'] ?? $director->full_name,
                'position' => $record->summary['position'] ?? $director->position,
                'status' => $record->status === 'verified' ? 'verified' : 'failed',
                'provider_reference' => $record->provider_reference,
                'director_status' => $record->summary['status'] ?? null,
                'verification_summary' => $record->summary,
                'director_data' => $response->json()['results']['cipc_director_search'] ?? ($response->json()['results'] ?? null),
                'verified_at' => now(),
            ]);

            return $record;
        } catch (\Throwable $exception) {
            $director->update([
                'status' => 'failed',
                'verified_at' => now(),
            ]);

            return $this->storeFailure($record, $requestPayload, $exception->getMessage());
        }
    }

    /**
     * Submit a driver licence verification and persist its history.
     */
    public function verifyDriverLicence(
        User $user,
        array $documentPaths,
        HttpUploadedFile $frontImage,
        ?HttpUploadedFile $backImage = null
    ): VerificationRecord {
        $record = $this->getRecord($user, 'driver_licence');

        $requestPayload = [
            'mode' => config('verifynow.mode', 'sandbox'),
            'document_type' => 'drivers_license',
            'uploaded_front_document_path' => $documentPaths['front'] ?? null,
            'uploaded_back_document_path' => $documentPaths['back'] ?? null,
        ];

        try {
            $response = $this->verifyNowClient->verifyDriverLicence($frontImage, $backImage);

            return $this->storeResult(
                $record,
                $requestPayload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractDriverLicenceSummary($response->json() ?? [])
            );
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $requestPayload, $exception->getMessage());
        }
    }

    /**
     * Submit a bank account verification and persist its history.
     *
     * @param  array<string, mixed>  $payload
     */
    public function verifyBankAccount(User $user, array $payload): VerificationRecord
    {
        $record = $this->getRecord($user, 'bank_account');

        try {
            $response = $this->verifyNowClient->verifyBankAccount([
                'type' => $payload['type'],
                'firstName' => $payload['first_name'] ?? null,
                'surname' => $payload['surname'],
                'identityNumber' => $payload['identity_number'],
                'identityType' => $payload['identity_type'],
                'bankAccountNumber' => $payload['bank_account_number'],
                'bankBranchCode' => $payload['bank_branch_code'],
                'bankAccountType' => $payload['bank_account_type'],
            ]);

            return $this->storeResult(
                $record,
                $payload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractBankAccountSummary($response->json() ?? [], $payload)
            );
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $payload, $exception->getMessage());
        }
    }

    /**
     * Retry a stored verification using the latest saved payload.
     */
    public function retry(VerificationRecord $record): VerificationRecord
    {
        $record->loadMissing(['attempts', 'user', 'verifiable']);

        $latestAttempt = $record->attempts()
            ->latest('attempted_at')
            ->latest('id')
            ->first();

        if ($latestAttempt === null) {
            return $this->storeFailure($record, [], 'No previous verification attempt is available for retry.');
        }

        return match ($record->module) {
            'sa_identity' => $this->retrySouthAfricanId($record, $latestAttempt),
            'enterprise' => $this->retryEnterprise($record, $latestAttempt),
            'enterprise_director' => $this->retryEnterpriseDirector($record, $latestAttempt),
            'driver_licence' => $this->retryDriverLicence($record, $latestAttempt),
            'bank_account' => $this->retryBankAccount($record, $latestAttempt),
            default => $this->storeFailure($record, $latestAttempt->request_payload ?? [], 'This verification module does not support retry yet.'),
        };
    }

    /**
     * Get or create a verification record by module.
     */
    protected function getRecord(User $user, string $module, ?Model $verifiable = null): VerificationRecord
    {
        return $user->verificationRecords()->firstOrCreate([
            'module' => $module,
            'verifiable_type' => $verifiable?->getMorphClass(),
            'verifiable_id' => $verifiable?->getKey(),
        ], [
            'provider' => 'verifynow',
            'status' => 'pending',
        ]);
    }

    /**
     * Retry a South African ID verification from the last request payload.
     */
    protected function retrySouthAfricanId(VerificationRecord $record, VerificationAttempt $attempt): VerificationRecord
    {
        $payload = $attempt->request_payload ?? [];
        $idNumber = $payload['id_number'] ?? null;

        if (! $idNumber) {
            return $this->storeFailure($record, $payload, 'No saved ID number is available for retry.');
        }

        try {
            $response = $this->verifyNowClient->verifySouthAfricanId($idNumber);

            return $this->storeResult(
                $record,
                $payload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractSouthAfricanIdSummary($response->json() ?? [])
            );
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $payload, $exception->getMessage());
        }
    }

    /**
     * Retry an enterprise verification from the last request payload.
     */
    protected function retryEnterprise(VerificationRecord $record, VerificationAttempt $attempt): VerificationRecord
    {
        $payload = $attempt->request_payload ?? [];

        try {
            $response = $this->verifyNowClient->verifyEnterprise(array_filter([
                'registration_number' => $payload['registration_number'] ?? null,
            ]));

            $record = $this->storeResult(
                $record,
                $payload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractEnterpriseSummary($response->json() ?? [])
            );

            if ($record->status === 'verified' && $record->verifiable instanceof ProcurementProfile) {
                $this->syncEnterpriseProfile($record->verifiable, $response->json() ?? []);
            }

            return $record;
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $payload, $exception->getMessage());
        }
    }

    /**
     * Retry an enterprise director verification from the last request payload.
     */
    protected function retryEnterpriseDirector(VerificationRecord $record, VerificationAttempt $attempt): VerificationRecord
    {
        $payload = $attempt->request_payload ?? [];
        $idNumber = $payload['id_number'] ?? null;

        if (! $idNumber) {
            return $this->storeFailure($record, $payload, 'No saved director ID number is available for retry.');
        }

        try {
            $response = $this->verifyNowClient->verifyEnterpriseDirector($idNumber);

            $record = $this->storeResult(
                $record,
                $payload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractEnterpriseDirectorSummary($response->json() ?? [], null, $payload)
            );

            if ($record->verifiable instanceof ProcurementDirector) {
                $record->verifiable->update([
                    'full_name' => $record->summary['director_name'] ?? $record->verifiable->full_name,
                    'position' => $record->summary['position'] ?? $record->verifiable->position,
                    'status' => $record->status === 'verified' ? 'verified' : 'failed',
                    'provider_reference' => $record->provider_reference,
                    'director_status' => $record->summary['status'] ?? null,
                    'verification_summary' => $record->summary,
                    'director_data' => $response->json()['results']['cipc_director_search'] ?? ($response->json()['results'] ?? null),
                    'verified_at' => now(),
                ]);
            }

            return $record;
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $payload, $exception->getMessage());
        }
    }

    /**
     * Retry a driver licence verification from stored file paths.
     */
    protected function retryDriverLicence(VerificationRecord $record, VerificationAttempt $attempt): VerificationRecord
    {
        $payload = $attempt->request_payload ?? [];
        $frontPath = $payload['uploaded_front_document_path'] ?? null;
        $backPath = $payload['uploaded_back_document_path'] ?? null;

        if (! $frontPath) {
            return $this->storeFailure($record, $payload, 'No saved front document path is available for retry.');
        }

        try {
            $response = $this->verifyNowClient->verifyDriverLicenceFromStoredPaths($frontPath, $backPath);

            return $this->storeResult(
                $record,
                $payload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractDriverLicenceSummary($response->json() ?? [])
            );
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $payload, $exception->getMessage());
        }
    }

    /**
     * Retry a bank account verification from the last request payload.
     */
    protected function retryBankAccount(VerificationRecord $record, VerificationAttempt $attempt): VerificationRecord
    {
        $payload = $attempt->request_payload ?? [];

        try {
            $response = $this->verifyNowClient->verifyBankAccount([
                'type' => $payload['type'] ?? 'Individual',
                'firstName' => $payload['first_name'] ?? null,
                'surname' => $payload['surname'] ?? '',
                'identityNumber' => $payload['identity_number'] ?? '',
                'identityType' => $payload['identity_type'] ?? '',
                'bankAccountNumber' => $payload['bank_account_number'] ?? '',
                'bankBranchCode' => $payload['bank_branch_code'] ?? '',
                'bankAccountType' => $payload['bank_account_type'] ?? '',
            ]);

            return $this->storeResult(
                $record,
                $payload,
                $response->json() ?? [],
                $response->body(),
                $response->successful(),
                $this->extractBankAccountSummary($response->json() ?? [], $payload)
            );
        } catch (\Throwable $exception) {
            return $this->storeFailure($record, $payload, $exception->getMessage());
        }
    }

    /**
     * Store a successful or failed provider response.
     *
     * @param  array<string, mixed>  $requestPayload
     * @param  array<string, mixed>  $jsonResponse
     * @param  array<string, mixed>  $summary
     */
    protected function storeResult(
        VerificationRecord $record,
        array $requestPayload,
        array $jsonResponse,
        string $rawResponse,
        bool $successful,
        array $summary
    ): VerificationRecord {
        return DB::transaction(function () use ($record, $requestPayload, $jsonResponse, $rawResponse, $successful, $summary): VerificationRecord {
            $status = $successful ? 'verified' : 'failed';
            $providerReference = $jsonResponse['requestId']
                ?? Arr::get($jsonResponse, 'results.id_document_verification.transaction_id')
                ?? Arr::get($jsonResponse, 'results.bank_account_verification.transaction_id')
                ?? Arr::get($jsonResponse, 'results.said_verification.transaction_id')
                ?? Arr::get($jsonResponse, 'results.cipc_company_match.transaction_id')
                ?? Arr::get($jsonResponse, 'results.cipc_director_search.transaction_id')
                ?? null;

            $record->update([
                'status' => $status,
                'provider_reference' => $providerReference,
                'summary' => $summary,
                'last_error' => $successful ? null : ($jsonResponse['error'] ?? 'Verification failed'),
                'last_verified_at' => now(),
            ]);

            $record->attempts()->create([
                'status' => $status,
                'provider_reference' => $providerReference,
                'request_payload' => $requestPayload,
                'raw_response' => $rawResponse,
                'processed_response' => $jsonResponse,
                'error_message' => $successful ? null : ($jsonResponse['error'] ?? 'Verification failed'),
                'attempted_at' => now(),
            ]);

            return $record->fresh(['attempts', 'verifiable']);
        });
    }

    /**
     * Store a failed verification attempt.
     *
     * @param  array<string, mixed>  $requestPayload
     */
    protected function storeFailure(VerificationRecord $record, array $requestPayload, string $message): VerificationRecord
    {
        return DB::transaction(function () use ($record, $requestPayload, $message): VerificationRecord {
            $record->update([
                'status' => 'failed',
                'last_error' => $message,
                'last_verified_at' => now(),
            ]);

            $record->attempts()->create([
                'status' => 'failed',
                'request_payload' => $requestPayload,
                'error_message' => $message,
                'attempted_at' => now(),
            ]);

            return $record->fresh(['attempts', 'verifiable']);
        });
    }

    /**
     * Extract a display summary for driver licence verification.
     *
     * @param  array<string, mixed>  $response
     * @return array<string, mixed>
     */
    protected function extractDriverLicenceSummary(array $response): array
    {
        return [
            'request_id' => $response['requestId'] ?? null,
            'success' => $response['success'] ?? false,
            'mode' => $response['mode'] ?? config('verifynow.mode', 'sandbox'),
            'document_type' => 'drivers_license',
        ];
    }

    /**
     * Extract a display summary for South African ID verification.
     *
     * @param  array<string, mixed>  $response
     * @return array<string, mixed>
     */
    protected function extractSouthAfricanIdSummary(array $response): array
    {
        return [
            'request_id' => $response['requestId'] ?? null,
            'success' => $response['success'] ?? false,
            'mode' => $response['mode'] ?? config('verifynow.mode', 'sandbox'),
            'report_type' => $response['reportType'] ?? 'said_verification',
            'transaction_id' => Arr::get($response, 'results.said_verification.transaction_id'),
            'status' => Arr::get($response, 'results.said_verification.realTimeResults.Status'),
        ];
    }

    /**
     * Extract a display summary for enterprise verification.
     *
     * @param  array<string, mixed>  $response
     * @return array<string, mixed>
     */
    protected function extractEnterpriseSummary(array $response): array
    {
        $result = Arr::get($response, 'results.cipc_company_match', Arr::get($response, 'results', []));

        return [
            'request_id' => $response['requestId'] ?? null,
            'success' => $response['success'] ?? false,
            'mode' => $response['mode'] ?? config('verifynow.mode', 'sandbox'),
            'transaction_id' => $result['transaction_id'] ?? null,
            'status' => $result['Status'] ?? $result['status'] ?? null,
            'company_name' => $result['company_name'] ?? $result['enterprise_name'] ?? null,
            'registration_number' => $result['registration_number'] ?? null,
            'vat_number' => $result['vat_number'] ?? $result['vat'] ?? null,
            'company_phone' => $result['company_phone'] ?? $result['telephone'] ?? $result['phone_number'] ?? null,
            'enterprise_type' => $result['enterprise_type'] ?? $result['company_type'] ?? null,
            'enterprise_address' => $result['enterprise_address'] ?? $result['registered_address'] ?? $result['address'] ?? null,
        ];
    }

    /**
     * Sync enterprise fields from the verified provider payload.
     *
     * @param  array<string, mixed>  $response
     */
    protected function syncEnterpriseProfile(ProcurementProfile $profile, array $response): void
    {
        $result = Arr::get($response, 'results.cipc_company_match', Arr::get($response, 'results', []));

        $profile->update([
            'company_name' => $result['company_name'] ?? $result['enterprise_name'] ?? $profile->company_name,
            'registration_number' => $result['registration_number'] ?? $profile->registration_number,
            'vat_number' => $result['vat_number'] ?? $result['vat'] ?? $profile->vat_number,
            'company_phone' => $result['company_phone'] ?? $result['telephone'] ?? $result['phone_number'] ?? $profile->company_phone,
            'enterprise_status' => $result['Status'] ?? $result['status'] ?? $profile->enterprise_status,
            'enterprise_type' => $result['enterprise_type'] ?? $result['company_type'] ?? $profile->enterprise_type,
            'enterprise_address' => $result['enterprise_address'] ?? $result['registered_address'] ?? $result['address'] ?? $profile->enterprise_address,
            'enterprise_data' => $result,
            'enterprise_synced_at' => now(),
        ]);
    }

    /**
     * Extract a display summary for enterprise director verification.
     *
     * @param  array<string, mixed>  $response
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    protected function extractEnterpriseDirectorSummary(
        array $response,
        ?ProcurementDirector $director = null,
        array $payload = []
    ): array {
        $result = Arr::get($response, 'results.cipc_director_search', Arr::get($response, 'results', []));

        return [
            'request_id' => $response['requestId'] ?? null,
            'success' => $response['success'] ?? false,
            'mode' => $response['mode'] ?? config('verifynow.mode', 'sandbox'),
            'transaction_id' => $result['transaction_id'] ?? null,
            'status' => $result['Status'] ?? $result['status'] ?? null,
            'director_name' => $result['director_name'] ?? $result['full_name'] ?? $director?->full_name ?? 'Pending verification',
            'id_number' => $director?->id_number ?? ($payload['id_number'] ?? null),
            'position' => $result['position'] ?? $result['director_position'] ?? null,
            'companies_count' => is_countable($result['companies'] ?? $result['director_companies'] ?? null)
                ? count($result['companies'] ?? $result['director_companies'])
                : null,
        ];
    }

    /**
     * Extract a display summary for bank account verification.
     *
     * @param  array<string, mixed>  $response
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    protected function extractBankAccountSummary(array $response, array $payload): array
    {
        return [
            'request_id' => $response['requestId'] ?? null,
            'success' => $response['success'] ?? false,
            'mode' => $response['mode'] ?? config('verifynow.mode', 'sandbox'),
            'account_type' => $payload['bank_account_type'],
            'branch_code' => $payload['bank_branch_code'],
            'identity_type' => $payload['identity_type'],
        ];
    }
}
