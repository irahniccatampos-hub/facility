@extends('layouts.admin')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Admin Dashboard</h1>
            <p class="text-slate-600 mt-1">Overview of facility activity and metrics</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.reservations.pending') }}" 
               class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200">
                📋 Review approvals
            </a>
            <a href="{{ route('admin.analytics.index') }}" 
               class="inline-flex items-center px-4 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:ring-4 focus:ring-blue-100 transition duration-200">
                📊 View analytics
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-blue-50">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-100 text-blue-800">Pending</span>
            </div>
            <div class="text-3xl font-bold text-slate-900 mb-1">{{ $pending }}</div>
            <div class="text-sm text-slate-500">Awaiting approval</div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-emerald-50">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800">Approved</span>
            </div>
            <div class="text-3xl font-bold text-slate-900 mb-1">{{ $approved }}</div>
            <div class="text-sm text-slate-500">Confirmed bookings</div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-violet-50">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-violet-100 text-violet-800">Active</span>
            </div>
            <div class="text-3xl font-bold text-slate-900 mb-1">{{ $facilities }}</div>
            <div class="text-sm text-slate-500">Total facilities</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-slate-900">Upcoming Reservations</h2>
                <a href="{{ route('admin.reservations.pending') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Manage approvals
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            <div class="space-y-3">
                @forelse($upcoming as $reservation)
                    <div class="flex items-center justify-between rounded-lg border border-slate-100 p-4 hover:bg-slate-50 transition duration-150">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <div class="font-medium text-slate-900">{{ $reservation->facility->name ?? 'Facility' }}</div>
                            </div>
                            <div class="text-sm text-slate-600 mb-1">{{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
                            <div class="text-xs text-slate-500">Requested by {{ $reservation->user->name ?? 'User' }}</div>
                        </div>
                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 capitalize">{{ $reservation->status }}</span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="text-slate-400 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-slate-500">No upcoming approved reservations</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-slate-900">Recent Notifications</h2>
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Latest 5</span>
            </div>
            <div class="space-y-3">
                @forelse($notifications as $note)
                    <div class="rounded-lg border border-slate-100 p-4 hover:bg-slate-50 transition duration-150">
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-blue-50">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-slate-900 mb-1">{{ $note->data['title'] ?? 'System Update' }}</div>
                                <div class="text-sm text-slate-600 mb-2">{{ $note->data['message'] ?? '' }}</div>
                                <div class="text-xs text-slate-500">{{ $note->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="text-slate-400 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <p class="text-slate-500">No notifications yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection