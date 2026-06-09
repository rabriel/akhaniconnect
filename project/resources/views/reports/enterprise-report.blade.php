<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Enterprise Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1, h2, h3 { margin: 0 0 8px; }
        .section { margin-bottom: 22px; }
        .muted { color: #6b7280; }
        .grid { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .grid th, .grid td { border: 1px solid #d1d5db; padding: 8px; text-align: left; vertical-align: top; }
        .brand { width: 170px; margin-bottom: 14px; }
        .card-title { font-size: 15px; font-weight: bold; margin-bottom: 8px; }
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
        <h1>Akhani Connect Enterprise Report</h1>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <div class="section">
        <div class="card-title">Enterprise Overview</div>
        <table class="grid">
            <tr><th>Company Name</th><td>{{ $profile->company_name ?: 'N/A' }}</td><th>Registration Number</th><td>{{ $profile->registration_number ?: 'N/A' }}</td></tr>
            <tr><th>VAT Number</th><td>{{ $profile->vat_number ?: 'N/A' }}</td><th>Enterprise Type</th><td>{{ $profile->enterprise_type ?: 'N/A' }}</td></tr>
            <tr><th>Enterprise Status</th><td>{{ $profile->enterprise_status ?: 'N/A' }}</td><th>Last Synced</th><td>{{ $profile->enterprise_synced_at?->format('Y-m-d H:i') ?: 'N/A' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="card-title">Contact And Address</div>
        <table class="grid">
            <tr><th>Company Phone</th><td>{{ $profile->company_phone ?: 'N/A' }}</td></tr>
            <tr><th>Registered Address</th><td>{{ $profile->enterprise_address ?: 'N/A' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="card-title">Verification Details</div>
        <table class="grid">
            <tr><th>Verification Status</th><td>{{ $verificationRecord?->summary['status'] ?? $profile->enterprise_status ?? 'N/A' }}</td><th>Reference</th><td>{{ $verificationRecord?->provider_reference ?: 'N/A' }}</td></tr>
            <tr><th>Transaction ID</th><td>{{ $verificationRecord?->summary['transaction_id'] ?? 'N/A' }}</td><th>Mode</th><td>{{ $verificationRecord?->summary['mode'] ?? 'N/A' }}</td></tr>
            @if (filled($verificationRecord?->last_error))
                <tr><th>Last Error</th><td colspan="3">{{ $verificationRecord->last_error }}</td></tr>
            @endif
        </table>
    </div>

    @if ($enterpriseData !== [])
        <div class="section">
            <div class="card-title">Additional Enterprise Data</div>
            <table class="grid">
                @foreach ($enterpriseData as $label => $value)
                    @continue(is_array($value))
                    <tr>
                        <th>{{ ucwords(str_replace('_', ' ', $label)) }}</th>
                        <td>{{ filled($value) ? $value : 'N/A' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
</body>
</html>
