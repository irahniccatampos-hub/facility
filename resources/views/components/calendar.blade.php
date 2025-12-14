@props(['id' => 'calendar', 'eventsUrl' => '#', 'editable' => false])

<div id="{{ $id }}" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 min-h-[500px]"></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('{{ $id }}');

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
            editable: {{ $editable ? 'true' : 'false' }},
            events: '{{ $eventsUrl }}',
            eventMouseEnter: function(info) {
                info.el.style.cursor = 'pointer';
            },
            eventClick: function(info) {
                // Show event details
                const event = info.event;
                const modal = `
                    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                        <div class="bg-white rounded-2xl max-w-md w-full p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-slate-900">Reservation Details</h3>
                                <button onclick="this.closest('.fixed').remove()" class="text-slate-400 hover:text-slate-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-3">
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
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700">Approved</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modal);
            },
            dayMaxEvents: 3,
            slotMinTime: '06:00:00',
            slotMaxTime: '22:00:00',
            weekends: true,
            nowIndicator: true,
            selectable: true,
            selectMirror: true,
            locale: 'en'
        });

        calendar.render();
    });
</script>
@endpush