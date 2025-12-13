@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Pending approvals</h1>
            <p class="text-slate-600">Review and approve reservation requests.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.reservations.calendar') }}" class="px-3 py-2 rounded-lg border border-slate-200 text-slate-800 hover:bg-slate-100">Open calendar</a>
            <a href="{{ route('admin.facilities.index') }}#createFacility" class="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">New facility</a>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-slate-600">
                <thead class="text-xs uppercase bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Facility</th>
                        <th class="px-4 py-3">Schedule</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending as $reservation)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $reservation->user->name ?? 'User' }}</td>
                            <td class="px-4 py-3">{{ $reservation->facility->name ?? 'Facility' }}</td>
                            <td class="px-4 py-3">{{ $reservation->start_time }} - {{ $reservation->end_time }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <form method="POST" action="{{ route('admin.reservations.approve', $reservation->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-emerald-600">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.reservations.reject', $reservation->id) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="reason" value="Rejected by admin">
                                    <button type="submit" class="text-amber-600">Reject</button>
                                </form>
                                <form method="POST" action="{{ route('admin.reservations.cancel', $reservation->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-slate-600">No pending reservations.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        @include('components.calendar', ['id' => 'admin-calendar', 'eventsUrl' => route('admin.calendar.events')])
    </div>
@endsection
