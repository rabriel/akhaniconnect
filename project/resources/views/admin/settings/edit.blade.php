@extends('layouts.app', [
    'title' => 'Platform Settings | Akhani Connect',
    'heading' => 'Platform Settings',
    'subheading' => 'Manage core Akhani Connect platform defaults.',
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-5">
                    <div class="col-md-6">
                        <label class="form-label required">Platform Name</label>
                        <input type="text" name="platform_name" class="form-control" value="{{ old('platform_name', $settings['platform_name']) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Support Email</label>
                        <input type="email" name="support_email" class="form-control" value="{{ old('support_email', $settings['support_email']) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Default Country</label>
                        <input type="text" name="default_country" class="form-control" value="{{ old('default_country', $settings['default_country']) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Welcome Message</label>
                        <input type="text" name="registration_welcome_message" class="form-control" value="{{ old('registration_welcome_message', $settings['registration_welcome_message']) }}" required>
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" class="btn btn-primary">Save settings</button>
                </div>
            </form>
        </div>
    </div>
@endsection
