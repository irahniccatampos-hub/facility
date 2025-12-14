@extends('layouts.user')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Facility Map</h1>
            <p class="text-slate-600 mt-1">Explore facilities around Digos City. Zoom, pan, and click markers for details.</p>
        </div>
        <a href="{{ route('user.facilities.index') }}" 
           class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200">
            📋 List view
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <div class="flex flex-col sm:flex-row items-center gap-3 mb-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="facilityFilter" 
                       class="pl-10 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                       placeholder="Search facilities by name...">
            </div>
            
            <select id="facilityType" 
                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3">
                <option value="">All facility types</option>
                <option value="Conference">Conference Room</option>
                <option value="Meeting">Meeting Room</option>
                <option value="Training">Training Room</option>
                <option value="Auditorium">Auditorium</option>
                <option value="Laboratory">Laboratory</option>
            </select>
            
            <select id="facilityFocus" 
                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3">
                <option value="">Jump to facility</option>
                @foreach($facilities as $f)
                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="facility-map" class="w-full h-[600px] rounded-xl overflow-hidden border border-slate-200"></div>
        
        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span>Active facilities</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <span>Available now</span>
                </div>
            </div>
            <div class="text-xs text-slate-500">
                Click markers for details • Drag to pan • Scroll to zoom
            </div>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const facilities = @json($facilities);
        const center = @json($center);

        const map = L.map('facility-map').setView([center.lat, center.lng], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add scale control
        L.control.scale().addTo(map);

        let markers = [];
        const activeIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div class="w-6 h-6 rounded-full bg-blue-500 border-2 border-white shadow-lg"></div>',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });

        const availableIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div class="w-6 h-6 rounded-full bg-emerald-500 border-2 border-white shadow-lg animate-pulse"></div>',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });

        function renderMarkers(filterText = '', typeFilter = '') {
            markers.forEach(m => map.removeLayer(m));
            markers = [];

            facilities
                .filter(f => f.name.toLowerCase().includes(filterText.toLowerCase()))
                .filter(f => !typeFilter || (f.type || '').toLowerCase() === typeFilter.toLowerCase())
                .forEach(f => {
                    if (!f.latitude || !f.longitude) return;
                    
                    // Use different icon based on availability
                    const isAvailable = Math.random() > 0.3; // Replace with actual availability logic
                    const icon = isAvailable ? availableIcon : activeIcon;
                    
                    const marker = L.marker([f.latitude, f.longitude], { icon }).addTo(map);
                    
                    const popupContent = `
                        <div class="p-3 min-w-[250px]">
                            <div class="flex items-start gap-3 mb-3">
                                ${f.thumbnail_url ? `<img src="${f.thumbnail_url}" class="w-16 h-12 rounded-lg object-cover border border-slate-200">` : ''}
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm">${f.name}</h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-1 text-xs rounded-full ${isAvailable ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700'}">
                                            ${isAvailable ? 'Available' : 'Active'}
                                        </span>
                                        <span class="text-xs text-slate-500">${f.type || 'Facility'}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                ${f.location ? `<div class="flex items-center gap-2 text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    ${f.location}
                                </div>` : ''}
                                <div class="flex items-center gap-2 text-amber-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    ${f.ratings_avg_rating ? f.ratings_avg_rating.toFixed(1) : 'No ratings'}
                                    <span class="text-slate-500 text-xs">(${f.ratings_count || 0})</span>
                                </div>
                                <div class="pt-2">
                                    <a href="/user/reservations#createReservation" 
                                       class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                        Book this facility
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    marker.bindPopup(popupContent);
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
                markers.forEach(marker => {
                    if (marker.getLatLng().lat === selected.latitude && 
                        marker.getLatLng().lng === selected.longitude) {
                        marker.openPopup();
                    }
                });
            }
        });
    </script>
    
    <style>
        .custom-marker {
            background: transparent;
            border: none;
        }
        
        .leaflet-popup-content {
            margin: 0;
        }
        
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
    </style>
    @endpush
@endsection