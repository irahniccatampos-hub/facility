@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Analytics</h1>
            <p class="text-slate-600">Usage insights from approved reservations.</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4">
            <h2 class="text-lg font-semibold text-slate-900 mb-3">Facility usage (hours)</h2>
            <canvas id="facilityUsageChart"></canvas>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4">
            <h2 class="text-lg font-semibold text-slate-900 mb-3">Peak hours</h2>
            <canvas id="peakHoursChart"></canvas>
        </div>
    </div>

    @push('scripts')
    <script>
        async function loadFacilityUsage() {
            const response = await fetch('{{ route('admin.analytics.facility') }}');
            const data = await response.json();
            const ctx = document.getElementById('facilityUsageChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.facility_name),
                    datasets: [{
                        label: 'Hours booked',
                        data: data.map(item => item.hours),
                        backgroundColor: '#2563eb',
                    }]
                }
            });
        }

        async function loadPeakHours() {
            const response = await fetch('{{ route('admin.analytics.peak') }}');
            const data = await response.json();
            const ctx = document.getElementById('peakHoursChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.hour),
                    datasets: [{
                        label: 'Reservations',
                        data: data.map(item => item.total),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        fill: true,
                    }]
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadFacilityUsage();
            loadPeakHours();
        });
    </script>
    @endpush
@endsection
