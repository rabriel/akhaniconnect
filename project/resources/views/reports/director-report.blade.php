<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Director Report</title>
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
        <h1>Akhani Connect Director Report</h1>
        <div class="muted">Generated {{ now()->format('d M Y H:i') }}</div>
    </div>

    <div class="section">
        <div class="card-title">Director Overview</div>
        <table class="grid">
            <tr><th>Full Name</th><td>{{ $director->full_name ?: 'N/A' }}</td><th>ID Number</th><td>{{ $director->id_number ?: 'N/A' }}</td></tr>
            <tr><th>Initials</th><td>{{ $director->initials ?: 'N/A' }}</td><th>Birth Date</th><td>{{ $director->birth_date?->format('Y-m-d') ?: 'N/A' }}</td></tr>
            <tr><th>Gender</th><td>{{ $director->gender ?: 'N/A' }}</td><th>Title</th><td>{{ $director->title ?: 'N/A' }}</td></tr>
            <tr><th>Marital Status</th><td>{{ $director->marital_status ?: 'N/A' }}</td><th>Privacy Status</th><td>{{ $director->privacy_status ?: 'N/A' }}</td></tr>
            <tr><th>Position</th><td>{{ $director->position ?: 'N/A' }}</td><th>Verification Status</th><td>{{ $director->director_status ?: ucfirst($director->status) }}</td></tr>
            <tr><th>Reference</th><td colspan="3">{{ $director->provider_reference ?: 'N/A' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="card-title">Contact Details</div>
        <table class="grid">
            <tr><th>Cellular Number</th><td>{{ $director->cellular_number ?: 'N/A' }}</td><th>Home Telephone</th><td>{{ $director->home_telephone ?: 'N/A' }}</td></tr>
            <tr><th>Work Telephone</th><td>{{ $director->work_telephone ?: 'N/A' }}</td><th>Email Address</th><td>{{ $director->email_address ?: 'N/A' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="card-title">Address Details</div>
        <table class="grid">
            <tr><th>Residential Address</th><td>{{ $director->residential_address ?: 'N/A' }}</td></tr>
            <tr><th>Postal Address</th><td>{{ $director->postal_address ?: 'N/A' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="card-title">Employment Details</div>
        <table class="grid">
            <tr><th>Employer</th><td>{{ $director->employer ?: 'N/A' }}</td><th>Number Of Enquiries</th><td>{{ $director->number_of_enquiries ?? 'N/A' }}</td></tr>
        </table>
    </div>

    @if ($fraudIndicators !== [])
        <div class="section">
            <div class="card-title">Fraud Indicators</div>
            <table class="grid">
                @foreach ($fraudIndicators as $label => $value)
                    <tr>
                        <th>{{ str_replace('_', ' ', $label) }}</th>
                        <td>{{ filled($value) ? $value : 'N/A' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    @if ($propertySummary !== [] || $directorSummary !== [])
        <div class="section">
            <div class="card-title">Summary Details</div>
            <table class="grid">
                @foreach ($propertySummary as $label => $value)
                    <tr>
                        <th>{{ str_replace('_', ' ', $label) }}</th>
                        <td>{{ filled($value) ? $value : 'N/A' }}</td>
                    </tr>
                @endforeach
                @foreach ($directorSummary as $label => $value)
                    <tr>
                        <th>{{ str_replace('_', ' ', $label) }}</th>
                        <td>{{ filled($value) ? $value : 'N/A' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    @if ($directorships !== [])
        <div class="section">
            <div class="card-title">Directorships</div>
            <table class="grid">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Registration Number</th>
                        <th>Appointment Date</th>
                        <th>Director Status</th>
                        <th>Commercial Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($directorships as $entry)
                        <tr>
                            <td>{{ $entry['CommercialName'] ?? 'N/A' }}</td>
                            <td>{{ $entry['RegistrationNumber'] ?? 'N/A' }}</td>
                            <td>{{ $entry['AppointmentDate'] ?? 'N/A' }}</td>
                            <td>{{ $entry['DirectorStatus'] ?? 'N/A' }}</td>
                            <td>{{ $entry['CommercialStatus'] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($employmentHistory !== [])
        <div class="section">
            <div class="card-title">Employment History</div>
            <table class="grid">
                <thead>
                    <tr>
                        <th>Employer</th>
                        <th>Designation</th>
                        <th>First Reported</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employmentHistory as $entry)
                        <tr>
                            <td>{{ $entry['EmployerDetail'] ?? 'N/A' }}</td>
                            <td>{{ $entry['Designation'] ?? 'N/A' }}</td>
                            <td>{{ $entry['FirstReportedDate'] ?? 'N/A' }}</td>
                            <td>{{ $entry['LastUpdatedDate'] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</body>
</html>
