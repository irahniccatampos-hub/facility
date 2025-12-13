@extends('layouts.user')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-100">Facility Map</h1>
            <p class="text-slate-400">Explore facilities around Digos City. Zoom, pan, and tap markers for details.</p>
        </div>
        <a href="{{ route('user.facilities.index') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">List view</a>
    </div>

    <div class="mb-4 flex items-center gap-3">
        <input type="text" id="facilityFilter" placeholder="Search facilities..." class="w-64 rounded-lg border-slate-700 bg-slate-900 text-slate-100">
        <select id="facilityType" class="rounded-lg border-slate-700 bg-slate-900 text-slate-100">
            <option value="">All types</option>
            <option value="Conference">Conference</option>
            <option value="Meeting">Meeting</option>
            <option value="Training">Training</option>
            <option value="Auditorium">Auditorium</option>
        </select>
        <select id="facilityFocus" class="rounded-lg border-slate-700 bg-slate-900 text-slate-100">
            <option value="">Jump to facility</option>
            @foreach($facilities as $f)
                <option value="{{ $f->id }}">{{ $f->name }}</option>
            @endforeach
        </select>
    </div>

    <div id="facility-map" class="w-full h-[500px] rounded-lg border border-slate-800 overflow-hidden"></div>

    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const facilities = @json($facilities);
        const center = @json($center);

        const map = L.map('facility-map').setView([center.lat, center.lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        let markers = [];

        function renderMarkers(filterText = '', typeFilter = '') {
            markers.forEach(m => map.removeLayer(m));
            markers = [];

            facilities
                .filter(f => f.name.toLowerCase().includes(filterText.toLowerCase()))
                .filter(f => !typeFilter || (f.type || '').toLowerCase() === typeFilter.toLowerCase())
                .forEach(f => {
                    if (!f.latitude || !f.longitude) return;
                    const marker = L.marker([f.latitude, f.longitude]).addTo(map);
                    marker.bindPopup(`<div class="text-sm">
                        <div class="font-semibold">${f.name}</div>
                        <div>${f.type ?? 'Facility'}</div>
                        <div class="text-slate-500">${f.location ?? ''}</div>
                    </div>`);
                    markers.push(marker);
                });
        }

        renderMarkers();

        document.getElementById('facilityFilter').addEventListener('input', () => {
            const text = document.getElementById('facilityFilter').value;
            const type = document.getElementById('facilityType').value;
            renderMarkers(text, type);
        });
        document.getElementById('facilityType').addEventListener('change', () => {
            const text = document.getElementById('facilityFilter').value;
            const type = document.getElementById('facilityType').value;
            renderMarkers(text, type);
        });

        document.getElementById('facilityFocus').addEventListener('change', (e) => {
            const id = e.target.value;
            const selected = facilities.find(f => f.id == id);
            if (selected && selected.latitude && selected.longitude) {
                map.setView([selected.latitude, selected.longitude], 17);
            }
        });
    </script>
    @endpush
@endsection
