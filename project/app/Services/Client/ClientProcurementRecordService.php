<?php

namespace App\Services\Client;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ClientProcurementRecordService
{
    /**
     * Search and filter procurement records for client review.
     *
     * @param  array<string, mixed>  $filters
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        $query = User::query()
            ->with(['procurementProfile', 'verificationRecords'])
            ->whereHas('role', fn ($roleQuery) => $roleQuery->where('slug', 'procurement'));

        $search = trim((string) ($filters['search'] ?? ''));

        if ($search !== '') {
            $query->where(function (Builder $builder) use ($search): void {
                $builder
                    ->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('surname', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhereHas('procurementProfile', function (Builder $profileQuery) use ($search): void {
                        $profileQuery
                            ->where('company_name', 'like', '%' . $search . '%')
                            ->orWhere('registration_number', 'like', '%' . $search . '%');
                    });
            });
        }

        if (filled($filters['progress'] ?? null)) {
            $this->applyProgressFilter($query, (string) $filters['progress']);
        }

        if (filled($filters['module'] ?? null)) {
            $module = (string) $filters['module'];

            $query->whereHas('verificationRecords', function (Builder $verificationQuery) use ($module): void {
                $verificationQuery
                    ->where('module', $module)
                    ->where('status', 'verified');
            });
        }

        return $query
            ->orderBy('first_name')
            ->orderBy('surname')
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Build a procurement record detail payload for the client view.
     *
     * @return array<string, mixed>
     */
    public function detail(User $procurementUser): array
    {
        $procurementUser->loadMissing([
            'profile',
            'procurementProfile.directors.verificationRecords',
            'verificationRecords.attempts',
            'documents',
        ]);

        $enterpriseRecord = $procurementUser->verificationRecords
            ->where('module', 'enterprise')
            ->first();

        $directorRecords = $procurementUser->verificationRecords
            ->where('module', 'enterprise_director')
            ->values();

        $verifiedDirectors = ($procurementUser->procurementProfile?->directors ?? collect())
            ->where('status', 'verified')
            ->values();
        $procurementDocuments = $procurementUser->documents
            ->where('category', 'procurement_profile')
            ->sortByDesc('uploaded_at')
            ->values();

        return [
            'user' => $procurementUser,
            'proofOfAddressUploaded' => $procurementUser->documents->where('category', 'proof_of_address')->isNotEmpty(),
            'verifiedModules' => $procurementUser->verificationRecords->where('status', 'verified')->pluck('module')->values(),
            'enterpriseRecord' => $enterpriseRecord,
            'directorRecords' => $directorRecords,
            'verifiedDirectors' => $verifiedDirectors,
            'procurementDocuments' => $procurementDocuments,
        ];
    }

    /**
     * Apply a progress-based filter to the query.
     */
    protected function applyProgressFilter(Builder $query, string $progress): void
    {
        match ($progress) {
            'verified' => $query->whereHas('procurementProfile', fn (Builder $profileQuery) => $profileQuery->where('verification_progress', 100)),
            'in_progress' => $query->whereHas('procurementProfile', fn (Builder $profileQuery) => $profileQuery->where('verification_progress', '>', 0)->where('verification_progress', '<', 100)),
            'pending' => $query->where(function (Builder $builder): void {
                $builder
                    ->whereDoesntHave('procurementProfile')
                    ->orWhereHas('procurementProfile', fn (Builder $profileQuery) => $profileQuery->where('verification_progress', 0));
            }),
            default => null,
        };
    }
}
