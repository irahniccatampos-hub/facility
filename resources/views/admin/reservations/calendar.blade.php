@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Reservations Calendar</h1>
            <p class="text-slate-600">View all reservations across facilities.</p>
        </div>
        <a href="{{ route('admin.reservations.pending') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Pending approvals</a>
    </div>

    @include('components.calendar', ['id' => 'admin-calendar-view', 'eventsUrl' => route('admin.calendar.events')])
@endsection
