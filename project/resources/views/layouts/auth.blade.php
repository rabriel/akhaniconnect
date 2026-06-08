<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="{{ url('/') }}/">
        <title>{{ $title ?? 'Akhani Connect' }}</title>
        <meta name="description" content="Akhani Connect recruitment and procurement platform." />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" />
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/akhani-theme.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body id="kt_body" class="bg-body">
        <div class="d-flex flex-column flex-root">
            <div class="auth-shell d-flex flex-column flex-column-fluid position-relative">
                <video class="auth-shell__media" autoplay muted loop playsinline poster="{{ asset('assets/media/auth/auth-bg.jpg') }}">
                    <source src="{{ asset('assets/media/auth/auth-bg.mp4') }}" type="video/mp4">
                </video>
                <div class="auth-shell__overlay"></div>
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20 position-relative">
                    <a href="{{ route('login') }}" class="mb-12">
                        <img alt="Akhani Connect Logo" src="{{ asset('logo.png') }}" class="h-60px" />
                    </a>

                    @yield('content')
                </div>

                <div class="d-flex flex-center flex-column-auto p-10 position-relative">
                    <div class="d-flex align-items-center fw-bold fs-6">
                        <span class="text-muted px-2">&copy; Copyright 2026 | Akhani Connect | All Rights Reserved</span>
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
