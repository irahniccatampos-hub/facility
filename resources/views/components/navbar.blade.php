<nav class="border-b border-slate-800 bg-slate-900 text-slate-100">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between h-14">
            <a href="{{ route('landing') }}" class="text-lg font-bold text-slate-100">Facility Reservation</a>
            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-slate-100">{{ auth()->user()->name }}</span>
                        @include('components.notification-bell')
                        <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                            @csrf
                            <input type="submit" value="Logout" class="text-sm text-red-400 hover:text-red-300 cursor-pointer border-0 bg-transparent">
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-slate-200 hover:text-white">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-slate-200 hover:text-white">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
