@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Admin Dashboard</h1>
            <p class="text-slate-600">Overview of facility activity.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.reservations.pending') }}" class="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Review approvals</a>
            <a href="{{ route('admin.analytics.index') }}" class="px-3 py-2 rounded-lg border border-slate-200 text-slate-800 hover:bg-slate-100">View analytics</a>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
            <div class="text-sm text-slate-500">Pending approvals</div>
            <div class="text-3xl font-semibold text-slate-900">{{ $pending }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
            <div class="text-sm text-slate-500">Approved bookings</div>
            <div class="text-3xl font-semibold text-slate-900">{{ $approved }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
            <div class="text-sm text-slate-500">Facilities</div>
            <div class="text-3xl font-semibold text-slate-900">{{ $facilities }}</div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-slate-900">Upcoming approved reservations</h2>
            <a href="{{ route('admin.reservations.pending') }}" class="text-sm text-blue-600">Manage approvals</a>
        </div>
        <div class="space-y-2">
            @forelse($upcoming as $reservation)
                <div class="flex items-center justify-between rounded border border-slate-100 p-3">
                    <div>
                        <div class="font-medium text-slate-900">{{ $reservation->facility->name ?? 'Facility' }}</div>
                    <div class="text-sm text-slate-600">{{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
                    <div class="text-xs text-slate-500">Requested by {{ $reservation->user->name ?? 'User' }}</div>
                </div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 capitalize">{{ $reservation->status }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-600">No upcoming approved reservations.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4 mt-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-slate-900">Notifications</h2>
            <span class="text-xs text-slate-500">Latest 5</span>
        </div>
        <div class="space-y-2">
            @forelse($notifications as $note)
                <div class="rounded border border-slate-100 p-3">
                    <div class="text-sm font-medium text-slate-900">{{ $note->data['title'] ?? 'Update' }}</div>
                    <div class="text-sm text-slate-600">{{ $note->data['message'] ?? '' }}</div>
                    <div class="text-xs text-slate-500 mt-1">{{ $note->created_at }}</div>
                </div>
            @empty
                <p class="text-sm text-slate-600">No notifications yet.</p>
            @endforelse
        </div>
    </div>
@endsection
