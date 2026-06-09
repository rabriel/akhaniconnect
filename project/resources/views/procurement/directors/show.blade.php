@extends('layouts.app', [
    'title' => 'Director Details | Akhani Connect',
    'heading' => 'Director Details',
    'subheading' => 'View the saved enterprise director information pulled from the verification API.',
])

@section('content')
    @php
        $directorData = $director->director_data ?? [];
        $results = is_array($directorData['results'] ?? null) ? $directorData['results'] : [];
        $fraudIndicators = is_array($results['fraud_indicators'] ?? null) ? $results['fraud_indicators'] : [];
        $propertySummary = is_array($results['property_summary'] ?? null) ? $results['property_summary'] : [];
        $directorSummary = is_array($results['director_summary'] ?? null) ? $results['director_summary'] : [];
        $maritalEnquiry = is_array($results['marital_enquiry'] ?? null) ? $results['marital_enquiry'] : [];
        $addressHistory = is_array($results['address_history'] ?? null) ? $results['address_history'] : [];
        $telephoneHistory = is_array($results['telephone_history'] ?? null) ? $results['telephone_history'] : [];
        $employmentHistory = is_array($results['employment_history'] ?? null) ? $results['employment_history'] : [];
        $enquiryHistory = is_array($results['enquiry_history'] ?? null) ? $results['enquiry_history'] : [];
        $directorEnquiryHistory = is_array($results['director_enquiry_history'] ?? null) ? $results['director_enquiry_history'] : [];
        $propertyInformation = is_array($results['property_information'] ?? null) ? $results['property_information'] : [];
        $directorships = is_array($results['directorships'] ?? null) ? $results['directorships'] : [];
    @endphp

    <div class="d-flex justify-content-end mb-6">
        <a href="{{ route('procurement.directors.report', $director) }}" class="btn btn-primary me-3">Download PDF</a>
        <a href="{{ route('procurement.directors.index') }}" class="btn btn-light-primary">Back To Directors</a>
    </div>

    <div class="card mb-8">
        <div class="card-body py-8">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-6">
                <div>
                    <div class="fs-2hx fw-bold">{{ $director->full_name ?: 'Director Record' }}</div>
                    <div class="text-muted mt-2">
                        {{ $director->title ?: 'Title not available' }}
                        @if ($director->position)
                            | {{ $director->position }}
                        @endif
                        @if ($director->id_number)
                            | ID {{ $director->id_number }}
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <span class="badge badge-light-{{ $director->status === 'verified' ? 'success' : ($director->status === 'failed' ? 'danger' : 'warning') }} fs-7 px-4 py-3">
                        {{ ucfirst($director->status) }}
                    </span>
                    <span class="badge badge-light-primary fs-7 px-4 py-3">
                        {{ $director->director_status ?: 'Status pending' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion accordion-icon-toggle" id="director_profile_accordion">
        <div class="accordion-item mb-5">
            <h2 class="accordion-header" id="director_identity_heading">
                <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#director_identity_body" aria-expanded="true" aria-controls="director_identity_body">
                    Identity Details
                </button>
            </h2>
            <div id="director_identity_body" class="accordion-collapse collapse show" aria-labelledby="director_identity_heading" data-bs-parent="#director_profile_accordion">
                <div class="accordion-body">
                    <div class="row g-6">
                        <div class="col-lg-6">
                            <div class="text-muted fs-7">Full Name</div>
                            <div class="fw-bold fs-5">{{ $director->full_name ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-muted fs-7">Initials</div>
                            <div class="fw-bold fs-5">{{ $director->initials ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-muted fs-7">ID Number</div>
                            <div class="fw-bold fs-5">{{ $director->id_number ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-muted fs-7">Birth Date</div>
                            <div class="fw-bold fs-5">{{ $director->birth_date?->format('Y-m-d') ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-muted fs-7">Gender</div>
                            <div class="fw-bold fs-5">{{ $director->gender ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-muted fs-7">Title</div>
                            <div class="fw-bold fs-5">{{ $director->title ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-muted fs-7">Marital Status</div>
                            <div class="fw-bold fs-5">{{ $director->marital_status ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-muted fs-7">Privacy Status</div>
                            <div class="fw-bold fs-5">{{ $director->privacy_status ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-muted fs-7">Director Status</div>
                            <div class="fw-bold fs-5">{{ $director->director_status ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item mb-5">
            <h2 class="accordion-header" id="director_contact_heading">
                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_contact_body" aria-expanded="false" aria-controls="director_contact_body">
                    Contact Details
                </button>
            </h2>
            <div id="director_contact_body" class="accordion-collapse collapse" aria-labelledby="director_contact_heading" data-bs-parent="#director_profile_accordion">
                <div class="accordion-body">
                    <div class="row g-6">
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Cellular Number</div>
                            <div class="fw-bold fs-5">{{ $director->cellular_number ?: 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Home Telephone</div>
                            <div class="fw-bold fs-5">{{ $director->home_telephone ?: 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Work Telephone</div>
                            <div class="fw-bold fs-5">{{ $director->work_telephone ?: 'N/A' }}</div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-muted fs-7">Email Address</div>
                            <div class="fw-bold fs-5 text-break">{{ $director->email_address ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item mb-5">
            <h2 class="accordion-header" id="director_address_heading">
                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_address_body" aria-expanded="false" aria-controls="director_address_body">
                    Address Details
                </button>
            </h2>
            <div id="director_address_body" class="accordion-collapse collapse" aria-labelledby="director_address_heading" data-bs-parent="#director_profile_accordion">
                <div class="accordion-body">
                    <div class="row g-6">
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Residential Address</div>
                            <div class="fw-bold fs-5">{{ $director->residential_address ?: 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Postal Address</div>
                            <div class="fw-bold fs-5">{{ $director->postal_address ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item mb-5">
            <h2 class="accordion-header" id="director_employment_heading">
                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_employment_body" aria-expanded="false" aria-controls="director_employment_body">
                    Employment Details
                </button>
            </h2>
            <div id="director_employment_body" class="accordion-collapse collapse" aria-labelledby="director_employment_heading" data-bs-parent="#director_profile_accordion">
                <div class="accordion-body">
                    <div class="row g-6">
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Employer</div>
                            <div class="fw-bold fs-5">{{ $director->employer ?: 'N/A' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted fs-7">Position</div>
                            <div class="fw-bold fs-5">{{ $director->position ?: 'N/A' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted fs-7">Number Of Enquiries</div>
                            <div class="fw-bold fs-5">{{ $director->number_of_enquiries ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($fraudIndicators !== [])
            <div class="accordion-item mb-5">
                <h2 class="accordion-header" id="director_fraud_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_fraud_body" aria-expanded="false" aria-controls="director_fraud_body">
                        Fraud Indicators
                    </button>
                </h2>
                <div id="director_fraud_body" class="accordion-collapse collapse" aria-labelledby="director_fraud_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        <div class="row g-6">
                            @foreach ($fraudIndicators as $label => $value)
                                <div class="col-md-4">
                                    <div class="text-muted fs-7">{{ str_replace('_', ' ', $label) }}</div>
                                    <div class="fw-bold fs-5">{{ filled($value) ? $value : 'N/A' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($propertySummary !== [] || $directorSummary !== [] || $maritalEnquiry !== [])
            <div class="accordion-item mb-5">
                <h2 class="accordion-header" id="director_summary_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_summary_body" aria-expanded="false" aria-controls="director_summary_body">
                        Summary Details
                    </button>
                </h2>
                <div id="director_summary_body" class="accordion-collapse collapse" aria-labelledby="director_summary_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        @if ($propertySummary !== [])
                            <div class="mb-8">
                                <h4 class="mb-4">Property Summary</h4>
                                <div class="row g-6">
                                    @foreach ($propertySummary as $label => $value)
                                        <div class="col-md-4">
                                            <div class="text-muted fs-7">{{ str_replace('_', ' ', $label) }}</div>
                                            <div class="fw-bold fs-5">{{ filled($value) ? $value : 'N/A' }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($directorSummary !== [])
                            <div class="mb-8">
                                <h4 class="mb-4">Director Summary</h4>
                                <div class="row g-6">
                                    @foreach ($directorSummary as $label => $value)
                                        <div class="col-md-4">
                                            <div class="text-muted fs-7">{{ str_replace('_', ' ', $label) }}</div>
                                            <div class="fw-bold fs-5">{{ filled($value) ? $value : 'N/A' }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($maritalEnquiry !== [])
                            <div>
                                <h4 class="mb-4">Marital Enquiry</h4>
                                <div class="row g-6">
                                    @foreach ($maritalEnquiry as $label => $value)
                                        <div class="col-md-4">
                                            <div class="text-muted fs-7">{{ str_replace('_', ' ', $label) }}</div>
                                            <div class="fw-bold fs-5">{{ filled($value) ? $value : 'N/A' }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if ($directorships !== [])
            <div class="accordion-item mb-5">
                <h2 class="accordion-header" id="director_directorships_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_directorships_body" aria-expanded="false" aria-controls="director_directorships_body">
                        Directorships
                    </button>
                </h2>
                <div id="director_directorships_body" class="accordion-collapse collapse" aria-labelledby="director_directorships_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        @foreach ($directorships as $entry)
                            <div class="border rounded p-5 mb-5">
                                <div class="fw-bold fs-4 mb-3">{{ $entry['CommercialName'] ?? 'Company' }}</div>
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Registration Number</div>
                                        <div class="fw-bold">{{ $entry['RegistrationNumber'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Appointment Date</div>
                                        <div class="fw-bold">{{ $entry['AppointmentDate'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Director Status</div>
                                        <div class="fw-bold">{{ $entry['DirectorStatus'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-muted fs-7">Commercial Status</div>
                                        <div class="fw-bold">{{ $entry['CommercialStatus'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-muted fs-7">Industry</div>
                                        <div class="fw-bold">{{ $entry['SICDescription'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-muted fs-7">Physical Address</div>
                                        <div class="fw-bold">{{ $entry['PhysicalAddress'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-muted fs-7">Postal Address</div>
                                        <div class="fw-bold">{{ $entry['PostalAddress'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($addressHistory !== [])
            <div class="accordion-item mb-5">
                <h2 class="accordion-header" id="director_address_history_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_address_history_body" aria-expanded="false" aria-controls="director_address_history_body">
                        Address History
                    </button>
                </h2>
                <div id="director_address_history_body" class="accordion-collapse collapse" aria-labelledby="director_address_history_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        @foreach ($addressHistory as $entry)
                            <div class="border rounded p-5 mb-5">
                                <div class="row g-5">
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Address Type</div>
                                        <div class="fw-bold">{{ $entry['AddressType'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">First Reported</div>
                                        <div class="fw-bold">{{ $entry['FirstReportedDate'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Last Updated</div>
                                        <div class="fw-bold">{{ $entry['LastUpdatedDate'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Postal Code</div>
                                        <div class="fw-bold">{{ $entry['PostalCode'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-muted fs-7">Address</div>
                                        <div class="fw-bold">{{ $entry['Address'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($telephoneHistory !== [])
            <div class="accordion-item mb-5">
                <h2 class="accordion-header" id="director_telephone_history_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_telephone_history_body" aria-expanded="false" aria-controls="director_telephone_history_body">
                        Telephone History
                    </button>
                </h2>
                <div id="director_telephone_history_body" class="accordion-collapse collapse" aria-labelledby="director_telephone_history_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        @foreach ($telephoneHistory as $entry)
                            <div class="border rounded p-5 mb-5">
                                <div class="row g-5">
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Type</div>
                                        <div class="fw-bold">{{ $entry['TelephoneType'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Telephone Number</div>
                                        <div class="fw-bold">{{ $entry['TelephoneNumber'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">First Reported</div>
                                        <div class="fw-bold">{{ $entry['FirstReportedDate'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Last Updated</div>
                                        <div class="fw-bold">{{ $entry['LastUpdatedDate'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($employmentHistory !== [])
            <div class="accordion-item mb-5">
                <h2 class="accordion-header" id="director_employment_history_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_employment_history_body" aria-expanded="false" aria-controls="director_employment_history_body">
                        Employment History
                    </button>
                </h2>
                <div id="director_employment_history_body" class="accordion-collapse collapse" aria-labelledby="director_employment_history_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        @foreach ($employmentHistory as $entry)
                            <div class="border rounded p-5 mb-5">
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <div class="text-muted fs-7">Employer</div>
                                        <div class="fw-bold">{{ $entry['EmployerDetail'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Designation</div>
                                        <div class="fw-bold">{{ $entry['Designation'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Last Updated</div>
                                        <div class="fw-bold">{{ $entry['LastUpdatedDate'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($enquiryHistory !== [])
            <div class="accordion-item mb-5">
                <h2 class="accordion-header" id="director_enquiry_history_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_enquiry_history_body" aria-expanded="false" aria-controls="director_enquiry_history_body">
                        Enquiry History
                    </button>
                </h2>
                <div id="director_enquiry_history_body" class="accordion-collapse collapse" aria-labelledby="director_enquiry_history_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        @foreach ($enquiryHistory as $entry)
                            <div class="border rounded p-5 mb-5">
                                <div class="row g-5">
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Enquiry Date</div>
                                        <div class="fw-bold">{{ $entry['EnquiryDate'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="text-muted fs-7">Subscriber Name</div>
                                        <div class="fw-bold">{{ $entry['SubscriberName'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Reason</div>
                                        <div class="fw-bold">{{ $entry['CreditGrantorEnquiryReasonDescription'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($directorEnquiryHistory !== [])
            <div class="accordion-item mb-5">
                <h2 class="accordion-header" id="director_director_enquiry_history_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_director_enquiry_history_body" aria-expanded="false" aria-controls="director_director_enquiry_history_body">
                        Director Enquiry History
                    </button>
                </h2>
                <div id="director_director_enquiry_history_body" class="accordion-collapse collapse" aria-labelledby="director_director_enquiry_history_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        @foreach ($directorEnquiryHistory as $entry)
                            <div class="border rounded p-5 mb-5">
                                <div class="row g-5">
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Enquiry Date</div>
                                        <div class="fw-bold">{{ $entry['EnquiryDate'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-muted fs-7">Subscriber Name</div>
                                        <div class="fw-bold">{{ $entry['SubscriberName'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted fs-7">Business Type</div>
                                        <div class="fw-bold">{{ $entry['SubscriberBusinessTypeDescription'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($propertyInformation !== [])
            <div class="accordion-item">
                <h2 class="accordion-header" id="director_property_information_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#director_property_information_body" aria-expanded="false" aria-controls="director_property_information_body">
                        Property Information
                    </button>
                </h2>
                <div id="director_property_information_body" class="accordion-collapse collapse" aria-labelledby="director_property_information_heading" data-bs-parent="#director_profile_accordion">
                    <div class="accordion-body">
                        @foreach ($propertyInformation as $entry)
                            <div class="border rounded p-5 mb-5">
                                <div class="fw-bold fs-4 mb-3">{{ $entry['PropertyTypeDescription'] ?? 'Property Record' }}</div>
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Authority</div>
                                        <div class="fw-bold">{{ $entry['AuthorityName'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Title Deed Number</div>
                                        <div class="fw-bold">{{ $entry['TitleDeedNumber'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Transfer Date</div>
                                        <div class="fw-bold">{{ $entry['TransferDate'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Purchase Date</div>
                                        <div class="fw-bold">{{ $entry['PurchaseDate'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Purchase Price</div>
                                        <div class="fw-bold">{{ $entry['PurchasePriceAmount'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted fs-7">Bond Amount</div>
                                        <div class="fw-bold">{{ $entry['BondAmount'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-muted fs-7">Physical Address</div>
                                        <div class="fw-bold">{{ $entry['PhysicalAddress'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
