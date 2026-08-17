@extends(auth()->check() ? 'layouts.app' : 'layouts.auth', ['title' => $title])

@section('content')
    <div class="card border-0 shadow-sm mx-auto ak-popia-card">
        <div class="card-body p-8 p-lg-12">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-6 mb-8">
                <div>
                    <span class="badge badge-light-primary text-primary fw-semibold mb-4">Privacy Notice</span>
                    <h2 class="text-dark fw-bolder mb-3">POPIA &amp; Personal Information Notice</h2>
                    <p class="text-muted fs-6 mb-0">
                        This notice explains how Akhani Connect collects, uses, stores, shares, and protects personal information.
                    </p>
                </div>
                <div class="ak-popia-version text-start text-lg-end">
                    <span class="d-block text-muted fs-8 text-uppercase fw-semibold mb-1">Notice version</span>
                    <span class="badge badge-light">{{ $privacyNoticeVersion }}</span>
                </div>
            </div>

            <div class="accordion accordion-flush ak-popia-accordion" id="ak_popia_notice">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="ak_popia_heading_one">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ak_popia_collapse_one" aria-expanded="true" aria-controls="ak_popia_collapse_one">
                            Information We Collect and Process
                        </button>
                    </h2>
                    <div id="ak_popia_collapse_one" class="accordion-collapse collapse show" aria-labelledby="ak_popia_heading_one" data-bs-parent="#ak_popia_notice">
                        <div class="accordion-body pt-6">
                            <ul class="ak-popia-list mb-0">
                                <li>Identity, profile, contact, company, employment, recruitment, and procurement information supplied by users or authorised representatives.</li>
                                <li>Verification inputs and outputs required to support recruitment screening, supplier verification, onboarding, and compliance workflows.</li>
                                <li>Technical session data such as IP address, browser details, and device information needed for security, analytics, and audit trails.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="ak_popia_heading_two">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ak_popia_collapse_two" aria-expanded="false" aria-controls="ak_popia_collapse_two">
                            How Information Is Used
                        </button>
                    </h2>
                    <div id="ak_popia_collapse_two" class="accordion-collapse collapse" aria-labelledby="ak_popia_heading_two" data-bs-parent="#ak_popia_notice">
                        <div class="accordion-body pt-6">
                            <ul class="ak-popia-list mb-0">
                                <li>To provide recruitment, supplier onboarding, verification, vetting, communication, reporting, and related platform services.</li>
                                <li>To support lawful business operations, contractual obligations, fraud prevention, platform administration, and user support.</li>
                                <li>To generate compliance records, role-based dashboards, notifications, reports, and audit history within Akhani Connect.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="ak_popia_heading_three">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ak_popia_collapse_three" aria-expanded="false" aria-controls="ak_popia_collapse_three">
                            Sharing, Safeguards, and Retention
                        </button>
                    </h2>
                    <div id="ak_popia_collapse_three" class="accordion-collapse collapse" aria-labelledby="ak_popia_heading_three" data-bs-parent="#ak_popia_notice">
                        <div class="accordion-body pt-6">
                            <ul class="ak-popia-list mb-0">
                                <li>Verification data may be securely shared with authorised third-party service providers, including VerifyNow, only for legitimate service delivery purposes.</li>
                                <li>Reasonable technical and organisational safeguards are used to protect personal information against loss, misuse, unauthorised access, or disclosure.</li>
                                <li>Records may be retained where required by law, contractual obligations, dispute resolution, security monitoring, or legitimate business requirements.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="ak_popia_heading_four">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#ak_popia_collapse_four" aria-expanded="false" aria-controls="ak_popia_collapse_four">
                            Your Rights
                        </button>
                    </h2>
                    <div id="ak_popia_collapse_four" class="accordion-collapse collapse" aria-labelledby="ak_popia_heading_four" data-bs-parent="#ak_popia_notice">
                        <div class="accordion-body pt-6">
                            <ul class="ak-popia-list mb-0">
                                <li>Users may request access to or correction of personal information held by Akhani Connect.</li>
                                <li>Users may request deletion where legally applicable and where no overriding retention obligation applies.</li>
                                <li>Users may contact Akhani Connect for privacy-related queries, updates, or requests regarding their information.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @auth
                <div class="d-flex justify-content-end mt-8">
                    <a href="{{ route('popia.notice.show') }}" class="btn btn-primary">Back to POPIA Acknowledgement</a>
                </div>
            @endauth
        </div>
    </div>
@endsection
