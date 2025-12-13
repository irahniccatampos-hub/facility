<aside class="w-64 bg-white border-r border-slate-200 min-h-screen p-4">
    <div class="mb-6 flex items-center gap-3">
        @if(auth()->user()->avatar_url)
            <img src="{{ asset(auth()->user()->avatar_url) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-slate-200">
        @endif
        <div>
            <div class="text-sm text-slate-500">Hello,</div>
            <div class="text-lg font-semibold text-slate-900">{{ auth()->user()->name }}</div>
        </div>
    </div>
    @php
        $links = [
            ['label' => 'Dashboard', 'route' => 'user.dashboard', 'icon' => '🏠'],
            ['label' => 'Facilities', 'route' => 'user.facilities.index', 'icon' => '🏢'],
            ['label' => 'Calendar', 'route' => 'user.reservations.index', 'icon' => '📅'],
            ['label' => 'Map', 'route' => 'user.map.index', 'icon' => '🗺️'],
            ['label' => 'Profile', 'route' => 'user.profile.edit', 'icon' => '⚙️'],
        ];
    @endphp
    <nav class="space-y-2">
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-2 rounded px-3 py-2 text-slate-800 hover:bg-slate-100 @if(request()->routeIs($link['route'])) bg-slate-900 text-white hover:bg-slate-900 @endif">
                <span>{{ $link['icon'] }}</span>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
        <a href="{{ route('user.reservations.index') }}#createReservation"
           class="flex items-center gap-2 rounded px-3 py-2 bg-blue-600 text-white hover:bg-blue-700">
            <span>➕</span>
            <span>New reservation</span>
        </a>
    </nav>
</aside>
