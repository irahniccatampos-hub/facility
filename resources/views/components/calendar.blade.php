@props(['id' => 'calendar', 'eventsUrl' => '#', 'editable' => false])

<div id="{{ $id }}" class="bg-white rounded-lg shadow border border-slate-200 p-4"></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('{{ $id }}');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            eventColor: '#2563eb',
            editable: {{ $editable ? 'true' : 'false' }},
            events: '{{ $eventsUrl }}',
        });

        calendar.render();
    });
</script>
@endpush
