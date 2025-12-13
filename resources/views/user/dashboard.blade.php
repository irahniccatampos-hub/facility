@extends('layouts.user')

@section('content')
    <div class="mb-6 flex items-center gap-4">
        @if(auth()->user()->avatar_url)
            <img src="{{ asset(auth()->user()->avatar_url) }}" alt="Avatar" class="w-14 h-14 rounded-full object-cover border border-slate-200">
        @endif
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="text-slate-600">Quick view of your reservations.</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('user.reservations.index') }}#createReservation" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
            <span>➕</span>
            <span>New reservation</span>
        </a>
        <a href="{{ route('user.facilities.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-slate-800 hover:bg-slate-100">
            <span>🏢</span>
            <span>Browse facilities</span>
        </a>
        <a href="{{ route('user.reservations.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-slate-800 hover:bg-slate-100">
            <span>📅</span>
            <span>Open calendar</span>
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
            <div class="text-sm text-slate-500">Pending requests</div>
            <div class="text-3xl font-semibold text-slate-900">{{ $pending }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
            <div class="text-sm text-slate-500">Approved</div>
            <div class="text-3xl font-semibold text-slate-900">{{ $approved }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
            <div class="text-sm text-slate-500">Upcoming</div>
            <div class="text-3xl font-semibold text-slate-900">{{ $upcoming->count() }}</div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-slate-900">Upcoming reservations</h2>
            <a href="{{ route('user.reservations.index') }}" class="text-sm text-blue-600">Open calendar</a>
        </div>
        <div class="space-y-2">
            @forelse($upcoming as $reservation)
                <div class="flex items-center justify-between rounded border border-slate-100 p-3">
                    <div>
                        <div class="font-medium text-slate-900">{{ $reservation->facility->name ?? 'Facility' }}</div>
                        <div class="text-sm text-slate-600">{{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full bg-slate-100 text-slate-700 capitalize">{{ $reservation->status }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-600">No upcoming reservations.</p>
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
