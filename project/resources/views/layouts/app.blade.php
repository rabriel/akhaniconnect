<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="{{ url('/') }}/">
        <title>{{ $title ?? 'Akhani Connect' }}</title>
        <meta name="description" content="Akhani Connect recruitment and procurement platform." />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" />
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/akhani-theme.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <div id="kt_aside"
                     class="aside bg-primary"
                     data-kt-drawer="true"
                     data-kt-drawer-name="aside"
                     data-kt-drawer-activate="{default: true, lg: false}"
                     data-kt-drawer-overlay="true"
                     data-kt-drawer-width="auto"
                     data-kt-drawer-direction="start"
                     data-kt-drawer-toggle="#kt_aside_toggle">
                    <div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto py-8" id="kt_aside_logo">
                        <a href="{{ route('dashboard') }}">
                            <img alt="Akhani Connect Logo" src="{{ asset('logo-white.png') }}" class="h-55px" />
                        </a>
                    </div>

                    <div class="aside-nav d-flex flex-column flex-column-fluid w-100 pt-5 pt-lg-0" id="kt_aside_nav">
                        <div id="kt_aside_menu"
                             class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-bold fs-6 flex-column-fluid align-items-center"
                             data-kt-menu="true">
                            <div class="menu-item py-3">
                                <a class="menu-link menu-center {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'active' : '' }}"
                                   href="{{ route('dashboard') }}"
                                   title="Dashboard"
                                   data-bs-toggle="tooltip"
                                   data-bs-trigger="hover"
                                   data-bs-dismiss="click"
                                   data-bs-placement="right">
                                    <span class="menu-icon me-0">
                                        <i class="bi bi-house fs-2"></i>
                                    </span>
                                </a>
                            </div>

                            <div class="menu-item py-3">
                                <a class="menu-link menu-center {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                                   href="{{ route('profile.edit') }}"
                                   title="My Profile"
                                   data-bs-toggle="tooltip"
                                   data-bs-trigger="hover"
                                   data-bs-dismiss="click"
                                   data-bs-placement="right">
                                    <span class="menu-icon me-0">
                                        <i class="bi bi-person fs-2"></i>
                                    </span>
                                </a>
                            </div>

                            <div class="menu-item py-3">
                                <a class="menu-link menu-center {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
                                   href="{{ route('notifications.index') }}"
                                   title="Notifications"
                                   data-bs-toggle="tooltip"
                                   data-bs-trigger="hover"
                                   data-bs-dismiss="click"
                                   data-bs-placement="right">
                                    <span class="menu-icon me-0">
                                        <i class="bi bi-bell fs-2"></i>
                                    </span>
                                </a>
                            </div>

                            <div class="menu-item py-3">
                                <a class="menu-link menu-center {{ request()->routeIs('popia.notice.*') || request()->routeIs('privacy.notice') ? 'active' : '' }}"
                                   href="{{ route('privacy.notice') }}"
                                   title="POPIA & Privacy"
                                   data-bs-toggle="tooltip"
                                   data-bs-trigger="hover"
                                   data-bs-dismiss="click"
                                   data-bs-placement="right">
                                    <span class="menu-icon me-0">
                                        <i class="bi bi-shield-lock fs-2"></i>
                                    </span>
                                </a>
                            </div>

                            @if (auth()->user()->hasRole('procurement'))
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('procurement.identity-verification.*') ? 'active' : '' }}"
                                       href="{{ route('procurement.identity-verification.show') }}"
                                       title="SA ID Verification"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-shield-check fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('procurement.profile.*') ? 'active' : '' }}"
                                       href="{{ route('procurement.profile.edit') }}"
                                       title="Procurement Profile"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-people fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('procurement.enterprise.*') ? 'active' : '' }}"
                                       href="{{ route('procurement.enterprise.edit') }}"
                                       title="Enterprise Details"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-building fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('procurement.directors.*') ? 'active' : '' }}"
                                       href="{{ route('procurement.directors.index') }}"
                                       title="Enterprise Directors"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-people fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('procurement.verifications.driver-licence*') ? 'active' : '' }}"
                                       href="{{ route('procurement.verifications.driver-licence') }}"
                                       title="Driver Licence Verification"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-file-earmark-arrow-up fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('procurement.documents.*') ? 'active' : '' }}"
                                       href="{{ route('procurement.documents.index') }}"
                                       title="Documents"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-file-earmark-arrow-up fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                            @endif

                            @if (auth()->user()->hasRole('candidate'))
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('candidate.identity-verification.*') ? 'active' : '' }}"
                                       href="{{ route('candidate.identity-verification.show') }}"
                                       title="SA ID Verification"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-shield-check fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('candidate.profile.*') ? 'active' : '' }}"
                                       href="{{ route('candidate.profile.edit') }}"
                                       title="Candidate Profile"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-people fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('candidate.verifications.driver-licence') ? 'active' : '' }}"
                                       href="{{ route('candidate.verifications.driver-licence') }}"
                                       title="Driver Licence Verification"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-file-earmark-arrow-up fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('candidate.jobs.*') ? 'active' : '' }}"
                                       href="{{ route('candidate.jobs.index') }}"
                                       title="Jobs"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                        <i class="bi bi-search fs-2"></i>
                                    </span>
                                </a>
                            </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('candidate.documents.*') ? 'active' : '' }}"
                                       href="{{ route('candidate.documents.index') }}"
                                       title="Documents"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-file-earmark-arrow-up fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('candidate.applications.*') ? 'active' : '' }}"
                                       href="{{ route('candidate.applications.index') }}"
                                       title="Applications"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-journal-text fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                            @endif

                            @if (auth()->user()->hasRole('client'))
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('client.identity-verification.*') ? 'active' : '' }}"
                                       href="{{ route('client.identity-verification.show') }}"
                                       title="SA ID Verification"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-shield-check fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('client.procurement-records.*') ? 'active' : '' }}"
                                       href="{{ route('client.procurement-records.index') }}"
                                       title="Procurement Records"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-search fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                            @endif

                            @if (auth()->user()->hasRole('recruitment'))
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('recruitment.identity-verification.*') ? 'active' : '' }}"
                                       href="{{ route('recruitment.identity-verification.show') }}"
                                       title="SA ID Verification"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-shield-check fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('recruitment.profile.*') ? 'active' : '' }}"
                                       href="{{ route('recruitment.profile.edit') }}"
                                       title="Company Profile"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-building fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('recruitment.candidates.*') ? 'active' : '' }}"
                                       href="{{ route('recruitment.candidates.index') }}"
                                       title="Candidates"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-search fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('recruitment.jobs.*') ? 'active' : '' }}"
                                       href="{{ route('recruitment.jobs.index') }}"
                                       title="Jobs"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-briefcase fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('recruitment.applications.*') ? 'active' : '' }}"
                                       href="{{ route('recruitment.applications.index') }}"
                                       title="Applications"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-people fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                            @endif

                            @can('users.manage')
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                       href="{{ route('admin.users.index') }}"
                                       title="Users"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-people fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                            @endcan

                            @can('clients.manage')
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}"
                                       href="{{ route('admin.clients.index') }}"
                                       title="Clients"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-briefcase fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                            @endcan

                            @can('reports.view')
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                                       href="{{ route('admin.reports.index') }}"
                                       title="Reports"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-bar-chart fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}"
                                       href="{{ route('admin.analytics.index') }}"
                                       title="Analytics"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-graph-up fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('admin.verifications.*') ? 'active' : '' }}"
                                       href="{{ route('admin.verifications.index') }}"
                                       title="Verification Logs"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-journal-text fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                            @endcan

                            @can('settings.manage')
                                <div class="menu-item py-3">
                                    <a class="menu-link menu-center {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                                       href="{{ route('admin.settings.edit') }}"
                                       title="Settings"
                                       data-bs-toggle="tooltip"
                                       data-bs-trigger="hover"
                                       data-bs-dismiss="click"
                                       data-bs-placement="right">
                                        <span class="menu-icon me-0">
                                            <i class="bi bi-gear fs-2"></i>
                                        </span>
                                    </a>
                                </div>
                            @endcan
                        </div>

                    </div>
                </div>

                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <div id="kt_header" class="header align-items-stretch">
                        <div class="container-fluid d-flex align-items-stretch justify-content-between">
                            <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                                <div class="btn btn-icon btn-active-color-white" id="kt_aside_toggle">
                                    <i class="bi bi-list fs-2x"></i>
                                </div>
                            </div>

                            <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge ak-role-badge">{{ auth()->user()->role->name ?? 'Account' }}</span>
                                    @if (auth()->user()->hasVerifiedIdentity())
                                        <span class="ak-verification-status">
                                            <span class="ak-verification-pill ak-verification-pill--verified">
                                                <i class="bi bi-check-lg"></i>
                                            </span>
                                            <span class="ak-verification-label ak-verification-label--verified">Verified</span>
                                        </span>
                                    @elseif (auth()->user()->hasRole('candidate') || auth()->user()->hasRole('client') || auth()->user()->hasRole('recruitment') || auth()->user()->hasRole('procurement'))
                                        <span class="ak-verification-status">
                                            <span class="ak-verification-pill ak-verification-pill--unverified">
                                                <i class="bi bi-x-lg"></i>
                                            </span>
                                            <span class="ak-verification-label ak-verification-label--unverified">Not Verified</span>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                                <div class="d-flex align-items-stretch" id="kt_header_nav"></div>

                                <div class="d-flex align-items-stretch flex-shrink-0">
                                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                                        <div class="btn btn-icon w-auto px-0 btn-active-color-primary">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px symbol-circle">
                                                    @if (auth()->user()->profile?->avatar_url)
                                                        <img src="{{ auth()->user()->profile->avatar_url }}" alt="Profile picture" class="object-fit-cover">
                                                    @else
                                                        <span class="symbol-label bg-light-warning text-warning fw-bold">
                                                            {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="d-none d-md-flex flex-column align-items-start justify-content-center ms-3">
                                                    <span class="text-dark fw-bold fs-7">{{ auth()->user()->full_name }}</span>
                                                    <span class="text-muted fw-semibold fs-8">{{ auth()->user()->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center ms-3">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                                                <i class="bi bi-power"></i>
                                                <span>Logout</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="toolbar py-5 py-lg-15" id="kt_toolbar">
                            <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
                                <div class="page-title d-flex flex-column me-3">
                                    <h1 class="d-flex text-dark fw-bolder my-1 fs-3">{{ $heading ?? 'Akhani Connect' }}</h1>
                                    <span class="text-muted fw-semibold fs-7">{{ $subheading ?? 'Recruitment and procurement operations platform' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <div id="kt_content_container" class="container-xxl">
                                @if (session('status'))
                                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                        <span class="svg-icon svg-icon-2hx svg-icon-success me-4">
                                            <i class="bi bi-check-circle-fill fs-2 text-success"></i>
                                        </span>
                                        <div class="d-flex flex-column">
                                            <span>{{ session('status') }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                        <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                                            <i class="bi bi-exclamation-octagon-fill fs-2 text-danger"></i>
                                        </span>
                                        <div class="d-flex flex-column">
                                            <span>{{ $errors->first() }}</span>
                                        </div>
                                    </div>
                                @endif

                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>var hostUrl = "{{ asset('assets') }}/";</script>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        @if (session('status') || session('error') || $errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (typeof Swal === 'undefined') {
                        return;
                    }

                    const message = @json(session('error') ?? session('status') ?? $errors->first());
                    const icon = @json(session('error') || $errors->any() ? 'error' : 'success');
                    const title = @json(session('error') || $errors->any() ? 'Something went wrong' : 'Success');

                    if (!message) {
                        return;
                    }

                    Swal.fire({
                        title: title,
                        text: message,
                        icon: icon,
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    });
                });
            </script>
        @endif
        @stack('scripts')
    </body>
</html>
