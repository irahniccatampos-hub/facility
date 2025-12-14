@extends('layouts.admin')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Reservations Calendar</h1>
            <p class="text-slate-600 mt-1">View all reservations across facilities</p>
        </div>
        <a href="{{ route('admin.reservations.pending') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200">
            📋 Pending approvals
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <span class="text-sm text-slate-600">Approved</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                    <span class="text-sm text-slate-600">Pending</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-slate-600">Your facility</span>
                </div>
            </div>
            <div class="text-sm text-slate-500">
                Today: {{ now()->format('F d, Y') }}
            </div>
        </div>
        
        <div id="admin-calendar-view" class="min-h-[600px] rounded-xl"></div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('admin-calendar-view');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                height: 'auto',
                themeSystem: 'standard',
                events: '{{ route('admin.calendar.events') }}',
                eventMouseEnter: function(info) {
                    info.el.style.cursor = 'pointer';
                },
                eventClick: function(info) {
                    const event = info.event;
                    const modal = `
                        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                            <div class="bg-white rounded-2xl max-w-md w-full p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-bold text-slate-900">Reservation Details</h3>
                                    <div role="button" tabindex="0" onclick="this.closest('.fixed').remove()" class="text-slate-400 hover:text-slate-900 cursor-pointer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <div class="text-sm text-slate-500">Facility</div>
                                        <div class="font-medium text-slate-900">${event.title}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-slate-500">Time</div>
                                        <div class="font-medium text-slate-900">${event.start.toLocaleString()} - ${event.end ? event.end.toLocaleString() : ''}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-slate-500">Status</div>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full ${event.extendedProps.status === 'approved' ? 'bg-emerald-50 text-emerald-700' : event.extendedProps.status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-700'}">
                                            ${event.extendedProps.status || 'pending'}
                                        </span>
                                    </div>
                                    <div class="pt-4 border-t border-slate-100">
                                        <div class="flex gap-2">
                                            <div role="button" tabindex="0" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 text-center cursor-pointer">
                                                Approve
                                            </div>
                                            <div role="button" tabindex="0" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 text-center cursor-pointer">
                                                Reject
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.insertAdjacentHTML('beforeend', modal);
                },
                dayMaxEvents: 4,
                slotMinTime: '06:00:00',
                slotMaxTime: '22:00:00',
                weekends: true,
                nowIndicator: true,
                selectable: false,
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '08:00',
                    endTime: '18:00',
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                }
            });

            calendar.render();
        });
    </script>
    @endpush
@endsection
