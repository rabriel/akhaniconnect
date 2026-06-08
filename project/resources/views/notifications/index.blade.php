@extends('layouts.app', [
    'title' => 'Notifications | Akhani Connect',
    'heading' => 'Notifications',
    'subheading' => 'Review follow-ups and system messages sent to your account.',
])

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Received</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($notifications as $notification)
                            <tr>
                                <td>{{ $notification->data['subject'] ?? 'Notification' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($notification->data['message'] ?? '', 90) }}</td>
                                <td>{{ $notification->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-light-{{ $notification->read_at ? 'success' : 'warning' }}">
                                        {{ $notification->read_at ? 'Read' : 'Unread' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @if (! $notification->read_at)
                                        <form method="POST" action="{{ route('notifications.update', $notification->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-light-primary">Mark as read</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-muted">No notifications yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection
