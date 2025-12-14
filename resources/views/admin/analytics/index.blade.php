@extends('layouts.admin')

@section('content')
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Analytics Dashboard</h1>
            <p class="text-slate-600 mt-1">Usage insights and performance metrics from approved reservations</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-800">Live Data</span>
            <span class="text-xs font-medium px-3 py-1 rounded-full bg-emerald-100 text-emerald-800">Updated Daily</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-slate-900">Facility Usage (Hours)</h2>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500">Last 30 days</span>
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                </div>
            </div>
            <div class="h-80">
                <canvas id="facilityUsageChart"></canvas>
            </div>
            <div class="mt-4 text-sm text-slate-500 text-center">
                Shows total hours booked per facility
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-slate-900">Peak Hours Analysis</h2>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500">24-hour distribution</span>
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                </div>
            </div>
            <div class="h-80">
                <canvas id="peakHoursChart"></canvas>
            </div>
            <div class="mt-4 text-sm text-slate-500 text-center">
                Reservation frequency by hour of day
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 rounded-lg bg-white shadow-sm">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-blue-600 font-medium">Average Booking Duration</div>
                    <div class="text-2xl font-bold text-slate-900">2.5 hrs</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl border border-emerald-100 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 rounded-lg bg-white shadow-sm">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-emerald-600 font-medium">Most Active Users</div>
                    <div class="text-2xl font-bold text-slate-900">8</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-violet-50 to-white rounded-xl border border-violet-100 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 rounded-lg bg-white shadow-sm">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-violet-600 font-medium">Utilization Rate</div>
                    <div class="text-2xl font-bold text-slate-900">78%</div>
                </div>
            </div>
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
                        backgroundColor: 'rgba(37, 99, 235, 0.7)',
                        borderColor: 'rgb(37, 99, 235)',
                        borderWidth: 1,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: 'rgb(248, 250, 252)',
                            bodyColor: 'rgb(248, 250, 252)',
                            padding: 12,
                            cornerRadius: 6
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.5)'
                            },
                            ticks: {
                                color: 'rgb(100, 116, 139)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: 'rgb(100, 116, 139)',
                                maxRotation: 45
                            }
                        }
                    }
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
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'rgb(16, 185, 129)',
                        pointBorderColor: 'white',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: 'rgb(248, 250, 252)',
                            bodyColor: 'rgb(248, 250, 252)',
                            padding: 12,
                            cornerRadius: 6
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.5)'
                            },
                            ticks: {
                                color: 'rgb(100, 116, 139)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(226, 232, 240, 0.5)'
                            },
                            ticks: {
                                color: 'rgb(100, 116, 139)'
                            }
                        }
                    }
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