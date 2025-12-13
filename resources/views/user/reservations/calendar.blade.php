@extends('layouts.user')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">My Reservations</h1>
            <p class="text-slate-600">Create and track room bookings.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('user.facilities.index') }}" class="px-3 py-2 border border-slate-200 rounded-lg text-slate-800 hover:bg-slate-100">Browse facilities</a>
            <button data-modal-target="createReservation" data-modal-toggle="createReservation" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">New reservation</button>
        </div>
    </div>

    @include('components.calendar', ['id' => 'user-calendar', 'eventsUrl' => route('user.calendar.events')])

    @include('user.reservations.create-modal', ['facilities' => $facilities])
@endsection
