<aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white min-h-screen p-5 shadow-xl">
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <div class="text-xs uppercase tracking-wider text-blue-300 font-medium">Admin Panel</div>
                <div class="text-xl font-bold">Control Center</div>
            </div>
        </div>
        <div class="text-sm text-slate-400 mt-2">Manage your facility reservations</div>
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
    
    <nav class="space-y-1 mb-8">
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-200 hover:bg-white/10 transition duration-200 group
                      @if(request()->routeIs($link['route'])) bg-gradient-to-r from-blue-500/20 to-blue-600/20 border-l-4 border-blue-500 @endif">
                <span class="text-lg group-hover:scale-110 transition-transform duration-200">{{ $link['icon'] }}</span>
                <span class="font-medium">{{ $link['label'] }}</span>
                @if(request()->routeIs($link['route']))
                    <span class="ml-auto w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                @endif
            </a>
        @endforeach
    </nav>
    
    <div class="pt-6 border-t border-slate-700/50">
        <div class="mb-4 px-3">
            <div class="text-xs uppercase tracking-wider text-slate-400 font-medium mb-2">Quick Actions</div>
        </div>
        <a href="{{ route('admin.facilities.index') }}#createFacility"
           class="flex items-center justify-center gap-2 rounded-xl px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 focus:ring-4 focus:ring-blue-300/30 transition duration-200 shadow-lg group">
            <span class="text-lg group-hover:rotate-90 transition-transform duration-300">➕</span>
            <span class="font-semibold">New facility</span>
        </a>
    </div>
    
    <div class="absolute bottom-6 left-5 right-5">
        <div class="text-xs text-slate-500 text-center">
            <div class="flex items-center justify-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>System Status: Online</span>
            </div>
            <div>v2.1.0</div>
        </div>
    </div>
</aside>