@extends('layouts.user')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">My Reservations</h1>
            <p class="text-slate-600 mt-1">Create and track your room bookings</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('user.facilities.index') }}" 
               class="inline-flex items-center px-4 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:ring-4 focus:ring-blue-100 transition duration-200">
                🏢 Browse facilities
            </a>
            <div role="button" tabindex="0" data-modal-target="createReservation" data-modal-toggle="createReservation" 
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200 cursor-pointer">
                📅 New reservation
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <div id="user-calendar" class="min-h-[500px] rounded-xl"></div>
    </div>

    @include('user.reservations.create-modal', ['facilities' => $facilities])
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('user-calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 'auto',
                themeSystem: 'standard',
                eventColor: '#2563eb',
                events: '{{ route('user.calendar.events') }}',
                eventMouseEnter: function(info) {
                    info.el.style.cursor = 'pointer';
                },
                eventClick: function(info) {
                    // You can add modal or details view here
                    console.log('Event clicked:', info.event);
                },
                dayMaxEvents: 3,
                slotMinTime: '06:00:00',
                slotMaxTime: '22:00:00',
                weekends: true,
                nowIndicator: true,
                editable: false,
                selectable: true,
                selectMirror: true,
                select: function(info) {
                    // Show create modal with pre-filled dates
                    const modal = document.querySelector('[data-modal-target="createReservation"]');
                    if (modal) {
                        modal.click();
                        // Pre-fill date inputs
                        const startInput = document.querySelector('input[name="start_time"]');
                        const endInput = document.querySelector('input[name="end_time"]');
                        if (startInput && endInput) {
                            startInput.value = info.startStr.substring(0, 16);
                            endInput.value = info.endStr.substring(0, 16);
                        }
                    }
                }
            });

            calendar.render();
        });
    </script>
    @endpush
@endsection