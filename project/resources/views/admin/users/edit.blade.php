@extends('layouts.app', [
    'title' => 'Edit User | Akhani Connect',
    'heading' => 'Edit User',
    'subheading' => 'Update user role, account details, and status.',
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="row g-5">
                    <div class="col-md-6">
                        <label class="form-label required">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Surname</label>
                        <input type="text" name="surname" class="form-control" value="{{ old('surname', $user->surname) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Role</label>
                        <select name="role" class="form-select" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->slug }}" @selected(old('role', $user->role?->slug) === $role->slug)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" @selected(old('status', $user->status) === 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $user->status) === 'inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" class="btn btn-primary">Save user changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
