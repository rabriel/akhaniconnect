<?php

namespace App\Services\Report;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ProcurementReportService
{
    /**
     * Build report view data for a procurement user.
     *
     * @return array<string, mixed>
     */
    public function build(User $procurementUser): array
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

        return [
            'user' => $procurementUser,
            'enterpriseRecord' => $enterpriseRecord,
            'directorRecords' => $directorRecords,
            'proofOfAddressUploaded' => $procurementUser->documents->where('category', 'proof_of_address')->isNotEmpty(),
            'verifiedModules' => $procurementUser->verificationRecords->where('status', 'verified')->pluck('module')->values(),
            'logoPath' => public_path('logo.png'),
        ];
    }

    /**
     * Generate a PDF download for a procurement report.
     */
    public function download(User $procurementUser): Response
    {
        $data = $this->build($procurementUser);
        $fileName = 'procurement-report-' . Str::slug($procurementUser->full_name ?: 'user') . '.pdf';

        return Pdf::loadView('reports.procurement-report', $data)
            ->setPaper('a4')
            ->download($fileName);
    }
}
