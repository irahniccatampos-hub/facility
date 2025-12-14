<aside class="w-64 bg-gradient-to-b from-white to-slate-50 border-r border-slate-200 min-h-screen p-5 shadow-sm">
    <div class="mb-8">
        <div class="flex items-center gap-4 p-3 rounded-xl bg-gradient-to-r from-blue-50 to-white border border-blue-100">
            @if(auth()->user()->avatar_url)
                <img src="{{ asset(auth()->user()->avatar_url) }}" alt="Avatar" 
                     class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow">
            @else
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-lg font-bold shadow">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            <div>
                <div class="text-xs text-blue-600 font-medium">Welcome back,</div>
                <div class="text-base font-bold text-slate-900">{{ auth()->user()->name }}</div>
            </div>
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
    
    <nav class="space-y-1 mb-6">
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-slate-700 hover:bg-white hover:text-blue-600 hover:shadow-sm transition duration-200 group
                      @if(request()->routeIs($link['route'])) bg-white text-blue-600 shadow-sm border border-blue-100 @endif">
                <span class="text-lg group-hover:scale-110 transition-transform duration-200">{{ $link['icon'] }}</span>
                <span class="font-medium">{{ $link['label'] }}</span>
                @if(request()->routeIs($link['route']))
                    <span class="ml-auto w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                @endif
            </a>
        @endforeach
    </nav>
    
    <div class="pt-6 border-t border-slate-200">
        <a href="{{ route('user.reservations.index') }}#createReservation"
           class="flex items-center justify-center gap-3 rounded-xl px-4 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200 shadow-lg group">
            <span class="text-lg group-hover:rotate-90 transition-transform duration-300">➕</span>
            <span class="font-semibold">New reservation</span>
        </a>
    </div>
    
    <div class="absolute bottom-6 left-5 right-5">
        <div class="text-xs text-slate-500 text-center">
            <div class="flex items-center justify-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Online • v2.1.0</span>
            </div>
        </div>
    </div>
</aside>