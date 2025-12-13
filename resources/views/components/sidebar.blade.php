<aside class="w-64 bg-slate-900 text-white min-h-screen p-4">
    <div class="mb-6">
        <div class="text-sm uppercase tracking-wide text-slate-400">Admin</div>
        <div class="text-xl font-semibold">Control</div>
    </div>
    @php
        $links = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => '🏠'],
            ['label' => 'Facilities', 'route' => 'admin.facilities.index', 'icon' => '🏢'],
            ['label' => 'Calendar', 'route' => 'admin.reservations.calendar', 'icon' => '📅'],
            ['label' => 'Approvals', 'route' => 'admin.reservations.pending', 'icon' => '✅'],
            ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'icon' => '📊'],
        ];
    @endphp
    <nav class="space-y-2">
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-2 rounded px-3 py-2 hover:bg-slate-800 @if(request()->routeIs($link['route'])) bg-slate-800 @endif">
                <span>{{ $link['icon'] }}</span>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
        <div class="pt-4 border-t border-slate-800 mt-4">
            <a href="{{ route('admin.facilities.index') }}#createFacility"
               class="flex items-center justify-center gap-2 rounded px-3 py-2 bg-blue-600 text-white hover:bg-blue-700">
                <span>➕</span>
                <span>New facility</span>
            </a>
        </div>
    </nav>
</aside>
