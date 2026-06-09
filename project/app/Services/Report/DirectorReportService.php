<?php

namespace App\Services\Report;

use App\Models\ProcurementDirector;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DirectorReportService
{
    /**
     * Build report view data for a procurement director.
     *
     * @return array<string, mixed>
     */
    public function build(ProcurementDirector $director): array
    {
        $director->loadMissing(['procurementProfile.user', 'verificationRecords.attempts']);

        $directorData = $director->director_data ?? [];
        $results = is_array($directorData['results'] ?? null) ? $directorData['results'] : [];

        return [
            'director' => $director,
            'user' => $director->procurementProfile?->user,
            'results' => $results,
            'fraudIndicators' => is_array($results['fraud_indicators'] ?? null) ? $results['fraud_indicators'] : [],
            'propertySummary' => is_array($results['property_summary'] ?? null) ? $results['property_summary'] : [],
            'directorSummary' => is_array($results['director_summary'] ?? null) ? $results['director_summary'] : [],
            'addressHistory' => is_array($results['address_history'] ?? null) ? $results['address_history'] : [],
            'telephoneHistory' => is_array($results['telephone_history'] ?? null) ? $results['telephone_history'] : [],
            'employmentHistory' => is_array($results['employment_history'] ?? null) ? $results['employment_history'] : [],
            'directorships' => is_array($results['directorships'] ?? null) ? $results['directorships'] : [],
            'logoPath' => public_path('logo.png'),
        ];
    }

    /**
     * Generate a PDF download for a director report.
     */
    public function download(ProcurementDirector $director): Response
    {
        $data = $this->build($director);
        $fileName = 'director-report-' . Str::slug($director->full_name ?: $director->id_number ?: 'director') . '.pdf';

        return Pdf::loadView('reports.director-report', $data)
            ->setPaper('a4')
            ->download($fileName);
    }
}
