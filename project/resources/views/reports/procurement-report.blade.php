<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Procurement Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1, h2, h3 { margin: 0 0 8px; }
        .section { margin-bottom: 24px; }
        .muted { color: #6b7280; }
        .grid { width: 100%; border-collapse: collapse; margin-top: 12px; }
        .grid th, .grid td { border: 1px solid #d1d5db; padding: 8px; text-align: left; vertical-align: top; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 10px; background: #e5e7eb; }
        .brand { width: 170px; margin-bottom: 14px; }
    </style>
</head>
<body>
    @php
        $logoDataUri = null;
        if (file_exists($logoPath)) {
            $logoDataUri = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }
    @endphp
    <div class="section">
        @if ($logoDataUri)
            <img src="{{ $logoDataUri }}" alt="Akhani Connect" class="brand">
        @endif
        <h1>Akhani Connect Procurement Report</h1>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <div class="section">
        <h2>Account Summary</h2>
        <table class="grid">
            <tr><th>Full Name</th><td>{{ $user->full_name }}</td><th>Email</th><td>{{ $user->email }}</td></tr>
            <tr><th>Phone</th><td>{{ $user->phone }}</td><th>Verification Progress</th><td>{{ $user->procurementProfile?->verification_progress ?? 0 }}%</td></tr>
            <tr><th>Company</th><td>{{ $user->procurementProfile?->company_name ?? 'Not synced yet' }}</td><th>Registration Number</th><td>{{ $user->procurementProfile?->registration_number ?? 'Not set' }}</td></tr>
            <tr><th>VAT Number</th><td>{{ $user->procurementProfile?->vat_number ?? 'Not synced yet' }}</td><th>Proof Of Address</th><td>{{ $proofOfAddressUploaded ? 'Uploaded' : 'Missing' }}</td></tr>
            <tr><th>Enterprise Status</th><td>{{ $user->procurementProfile?->enterprise_status ?? 'Not synced yet' }}</td><th>Enterprise Type</th><td>{{ $user->procurementProfile?->enterprise_type ?? 'Not synced yet' }}</td></tr>
            <tr><th>Registered Address</th><td colspan="3">{{ $user->procurementProfile?->enterprise_address ?? 'Not synced yet' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Verified Modules</h2>
        <div>{{ $verifiedModules->isNotEmpty() ? $verifiedModules->implode(', ') : 'No verified modules yet' }}</div>
    </div>

    <div class="section">
        <h2>CIPC Enterprise Verification</h2>
        <table class="grid">
            <tr><th>Status</th><td>{{ $enterpriseRecord?->summary['status'] ?? 'Pending' }}</td><th>Reference</th><td>{{ $enterpriseRecord?->provider_reference ?? 'N/A' }}</td></tr>
            <tr><th>Company Name</th><td>{{ $enterpriseRecord?->summary['company_name'] ?? 'N/A' }}</td><th>Registration Number</th><td>{{ $enterpriseRecord?->summary['registration_number'] ?? 'N/A' }}</td></tr>
            <tr><th>VAT Number</th><td>{{ $enterpriseRecord?->summary['vat_number'] ?? 'N/A' }}</td><th>Company Phone</th><td>{{ $enterpriseRecord?->summary['company_phone'] ?? 'N/A' }}</td></tr>
            <tr><th>Enterprise Type</th><td>{{ $enterpriseRecord?->summary['enterprise_type'] ?? 'N/A' }}</td><th>Registered Address</th><td>{{ $enterpriseRecord?->summary['enterprise_address'] ?? 'N/A' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Enterprise Directors</h2>
        <table class="grid">
            <thead>
                <tr>
                    <th>Director</th>
                    <th>ID Number</th>
                    <th>Position</th>
                    <th>Director Status</th>
                    <th>Status</th>
                    <th>Reference</th>
                    <th>Companies Found</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user->procurementProfile?->directors ?? [] as $director)
                    <tr>
                        <td>{{ $director->full_name ?: 'Not synced yet' }}</td>
                        <td>{{ $director->id_number }}</td>
                        <td>{{ $director->position ?? 'Not synced yet' }}</td>
                        <td>{{ $director->director_status ?? 'Not synced yet' }}</td>
                        <td>{{ ucfirst($director->status) }}</td>
                        <td>{{ $director->provider_reference ?? 'N/A' }}</td>
                        <td>{{ $director->verification_summary['companies_count'] ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No directors captured yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Verification Records</h2>
        <table class="grid">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Status</th>
                    <th>Reference</th>
                    <th>Last Verified</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user->verificationRecords as $verificationRecord)
                    <tr>
                        <td>{{ str_replace('_', ' ', ucfirst($verificationRecord->module)) }}</td>
                        <td>{{ ucfirst($verificationRecord->status) }}</td>
                        <td>{{ $verificationRecord->provider_reference ?? 'N/A' }}</td>
                        <td>{{ $verificationRecord->last_verified_at?->format('d M Y H:i') ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No verification records captured yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
