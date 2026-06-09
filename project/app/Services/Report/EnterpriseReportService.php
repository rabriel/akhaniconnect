<?php

namespace App\Services\Report;

use App\Models\ProcurementProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class EnterpriseReportService
{
    /**
     * Build report view data for a procurement enterprise profile.
     *
     * @return array<string, mixed>
     */
    public function build(ProcurementProfile $profile): array
    {
        $profile->loadMissing(['user', 'verificationRecords.attempts']);

        $enterpriseData = $profile->enterprise_data ?? [];
        $verificationRecord = $profile->verificationRecords()
            ->where('module', 'enterprise')
            ->latest('id')
            ->first();

        return [
            'profile' => $profile,
            'user' => $profile->user,
            'enterpriseData' => $enterpriseData,
            'verificationRecord' => $verificationRecord,
            'logoPath' => public_path('logo.png'),
        ];
    }

    /**
     * Generate a PDF download for an enterprise report.
     */
    public function download(ProcurementProfile $profile): Response
    {
        $data = $this->build($profile);
        $fileName = 'enterprise-report-' . Str::slug($profile->company_name ?: $profile->registration_number ?: 'enterprise') . '.pdf';

        return Pdf::loadView('reports.enterprise-report', $data)
            ->setPaper('a4')
            ->download($fileName);
    }
}
