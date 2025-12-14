@extends('layouts.user')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            @if(auth()->user()->avatar_url)
                <div class="relative">
                    <img src="{{ asset(auth()->user()->avatar_url) }}" alt="Avatar" 
                         class="w-16 h-16 rounded-2xl object-cover border-4 border-white shadow-lg">
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-emerald-500 border-2 border-white"></div>
                </div>
            @else
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="text-slate-600 mt-1">Quick overview of your reservations and activities</p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('user.reservations.index') }}#createReservation" 
           class="inline-flex items-center gap-3 px-5 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 shadow-lg transition duration-200">
            <span class="text-lg">➕</span>
            <span class="font-semibold">New reservation</span>
        </a>
        <a href="{{ route('user.facilities.index') }}" 
           class="inline-flex items-center gap-3 px-5 py-3.5 rounded-xl border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 focus:ring-4 focus:ring-blue-100 shadow-sm transition duration-200">
            <span class="text-lg">🏢</span>
            <span class="font-medium">Browse facilities</span>
        </a>
        <a href="{{ route('user.reservations.index') }}" 
           class="inline-flex items-center gap-3 px-5 py-3.5 rounded-xl border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 focus:ring-4 focus:ring-blue-100 shadow-sm transition duration-200">
            <span class="text-lg">📅</span>
            <span class="font-medium">Open calendar</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-amber-50">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-amber-100 text-amber-800">Pending</span>
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
                <div class="p-3 rounded-lg bg-blue-50">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-100 text-blue-800">Upcoming</span>
            </div>
            <div class="text-3xl font-bold text-slate-900 mb-1">{{ $upcoming->count() }}</div>
            <div class="text-sm text-slate-500">Scheduled soon</div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-slate-900">Upcoming Reservations</h2>
            <a href="{{ route('user.reservations.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
                Open calendar
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
                            <div class="w-2 h-2 rounded-full 
                                @if($reservation->status === 'approved') bg-emerald-500 
                                @elseif($reservation->status === 'pending') bg-amber-500 
                                @else bg-slate-400 @endif">
                            </div>
                            <div class="font-medium text-slate-900">{{ $reservation->facility->name ?? 'Facility' }}</div>
                        </div>
                        <div class="text-sm text-slate-600 mb-1">{{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
                    </div>
                    <span class="text-xs font-medium px-3 py-1 rounded-full 
                        @if($reservation->status === 'approved') bg-emerald-50 text-emerald-700 
                        @elseif($reservation->status === 'pending') bg-amber-50 text-amber-700 
                        @else bg-slate-100 text-slate-700 @endif capitalize">
                        {{ $reservation->status }}
                    </span>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="text-slate-400 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-slate-500">No upcoming reservations</p>
                    <p class="text-sm text-slate-400 mt-1">Create your first reservation to get started</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
