@extends('layouts.app', ['title' => $title])

@section('content')
    <div class="card border-0 shadow-sm mx-auto ak-popia-card">
        <div class="card-body p-8 p-lg-12">
            <div class="d-flex flex-column flex-lg-row align-items-lg-start justify-content-between gap-6 mb-8">
                <div>
                    <span class="badge badge-light-primary text-primary fw-semibold mb-4">POPIA Notice</span>
                    <h2 class="text-dark fw-bolder mb-3">POPIA &amp; Personal Information Notice</h2>
                    <p class="text-muted fs-6 mb-0">
                        Akhani Connect respects your privacy and processes personal information in accordance with the
                        Protection of Personal Information Act (POPIA).
                    </p>
                </div>
                <div class="ak-popia-version text-start text-lg-end">
                    <span class="d-block text-muted fs-8 text-uppercase fw-semibold mb-1">Notice version</span>
                    <span class="badge badge-light">{{ $privacyNoticeVersion }}</span>
                </div>
            </div>

            <div class="row g-5 mb-8">
                <div class="col-12 col-xl-6">
                    <div class="ak-popia-panel h-100">
                        <h3 class="fs-5 text-dark fw-bold mb-4">By continuing to use Akhani Connect, you acknowledge that:</h3>
                        <ul class="ak-popia-list mb-0">
                            <li>Personal information may be collected and processed for recruitment, supplier verification, vetting and related platform services.</li>
                            <li>Information required for verification may be securely submitted to authorised third-party verification providers, including VerifyNow.</li>
                            <li>Information will only be processed for legitimate purposes associated with Akhani Connect services.</li>
                            <li>Reasonable technical and organisational safeguards are used to protect personal information.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="ak-popia-panel h-100">
                        <h3 class="fs-5 text-dark fw-bold mb-4">Your rights and record retention</h3>
                        <ul class="ak-popia-list mb-0">
                            <li>Users may request access to or correction of their personal information.</li>
                            <li>Users may request deletion where legally applicable.</li>
                            <li>Certain records may need to be retained where required by law, contractual obligations or legitimate business requirements.</li>
                            <li>This acknowledgement is recorded for audit and compliance purposes for each login session.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('popia.notice.store') }}" class="ak-popia-form">
                @csrf

                <div class="form-check form-check-custom form-check-solid align-items-start rounded-3 bg-light p-5 mb-8 ak-popia-check">
                    <input
                        id="popia_acknowledged"
                        class="form-check-input mt-1 ak-popia-check__input"
                        type="checkbox"
                        name="acknowledged"
                        value="1"
                        data-popia-acknowledgement
                    >
                    <label class="form-check-label ms-3 text-dark fw-semibold lh-lg ak-popia-check__label" for="popia_acknowledged">
                        I acknowledge that I have read and understood the Akhani Connect Privacy Notice.
                    </label>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-between align-items-stretch align-items-sm-center">
                    <a href="{{ route('privacy.notice') }}" class="btn btn-light-primary">
                        View Full Privacy Notice
                    </a>
                    <button type="submit" class="btn btn-primary" data-popia-submit disabled>
                        Accept &amp; Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/popia-acknowledgement.js') }}"></script>
@endpush
