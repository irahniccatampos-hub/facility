@extends('layouts.admin')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Pending Approvals</h1>
            <p class="text-slate-600 mt-1">Review and approve reservation requests</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.reservations.calendar') }}" 
               class="inline-flex items-center px-4 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:ring-4 focus:ring-blue-100 transition duration-200">
                📅 Open calendar
            </a>
            <a href="{{ route('admin.facilities.index') }}#createFacility" 
               class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200">
                🏢 New facility
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Facility</th>
                        <th class="px-6 py-4 font-medium">Schedule</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending as $reservation)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-medium">
                                        {{ substr($reservation->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="font-medium text-slate-900">{{ $reservation->user->name ?? 'User' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $reservation->facility->name ?? 'Facility' }}</div>
                                <div class="text-xs text-slate-500">{{ $reservation->facility->type ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $reservation->start_time }}</div>
                                <div class="text-xs text-slate-500">to {{ $reservation->end_time }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.reservations.approve', $reservation->id) }}" class="inline">
                                        @csrf
                                        <input type="submit"
                                               value="Approve"
                                               class="px-4 py-2 text-xs font-medium text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg focus:ring-4 focus:ring-emerald-200 transition duration-200 cursor-pointer">
                                    </form>
                                    <form method="POST" action="{{ route('admin.reservations.reject', $reservation->id) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="reason" value="Rejected by admin">
                                        <input type="submit"
                                               value="Reject"
                                               class="px-4 py-2 text-xs font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg focus:ring-4 focus:ring-amber-200 transition duration-200 cursor-pointer">
                                    </form>
                                    <form method="POST" action="{{ route('admin.reservations.cancel', $reservation->id) }}" class="inline">
                                        @csrf
                                        <input type="submit"
                                               value="Cancel"
                                               class="px-4 py-2 text-xs font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg focus:ring-4 focus:ring-red-200 transition duration-200 cursor-pointer">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="text-slate-400">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-slate-500">No pending reservations</p>
                                    <p class="text-sm text-slate-400 mt-1">All requests have been processed</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pending->count() > 0)
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            <div class="text-sm text-slate-500">
                Showing <span class="font-medium">{{ $pending->count() }}</span> pending reservations
            </div>
        </div>
        @endif
    </div>

    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-slate-900">Reservation Calendar</h2>
            <span class="text-sm text-slate-500">Live overview</span>
        </div>
        @include('components.calendar', ['id' => 'admin-calendar', 'eventsUrl' => route('admin.calendar.events')])
    </div>  
@endsection
