<nav class="border-b border-slate-800 bg-slate-900 text-slate-100">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between h-14">
            <a href="{{ route('landing') }}" class="text-lg font-bold text-slate-100">Facility Reservation</a>
            <div class="flex items-center gap-4">
                @auth
                    
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <button type="button" id="notif-toggle" class="relative text-slate-200 hover:text-white">
                                <span class="text-xl">🔔</span>
                                <span id="notif-count" class="hidden absolute -top-1 -right-1 bg-red-600 text-white text-[10px] rounded-full px-1.5"></span>
                            </button>
                            <div id="notif-panel" class="hidden absolute right-0 mt-2 w-72 bg-slate-800 border border-slate-700 rounded-lg shadow-lg text-sm z-50">
                                <div class="p-3 border-b border-slate-700 flex items-center justify-between">
                                    <span class="font-semibold text-slate-100">Notifications</span>
                                    <button type="button" id="mark-read" class="text-xs text-blue-300">Mark read</button>
                                </div>
                                <div id="notif-list" class="max-h-64 overflow-y-auto p-3 space-y-2 text-slate-100"></div>
                            </div>
                        </div>
                       
                        <span class="text-sm text-slate-100">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-400 hover:text-red-300">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-slate-200 hover:text-white">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-slate-200 hover:text-white">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    (function() {
        // Notifications polling and dropdown
        const notifToggle = document.getElementById('notif-toggle');
        const notifPanel = document.getElementById('notif-panel');
        const notifList = document.getElementById('notif-list');
        const notifCount = document.getElementById('notif-count');
        const markRead = document.getElementById('mark-read');
        let latestIds = [];
        const sound = new Audio('https://actions.google.com/sounds/v1/alarms/beep_short.ogg');

        async function fetchNotifications(playSound = false) {
            try {
                const res = await fetch('{{ route('notifications.index') }}');
                const data = await res.json();
                const items = data.notifications || [];
                notifList.innerHTML = items.length === 0 ? '<div class="text-xs text-slate-400">No new notifications</div>' : '';
                items.forEach(n => {
                    const el = document.createElement('div');
                    el.className = 'rounded border border-slate-700 p-2';
                    el.innerHTML = `<div class="font-semibold">${n.title}</div><div class="text-slate-300">${n.message}</div><div class="text-[10px] text-slate-500">${n.created_at}</div>`;
                    notifList.appendChild(el);
                });
                const unread = data.unread ?? items.length;
                if (unread) {
                    notifCount.classList.remove('hidden');
                    notifCount.textContent = unread;
                } else {
                    notifCount.classList.add('hidden');
                }
                const ids = items.map(n => n.id).join(',');
                if (playSound && ids !== latestIds.join(',')) {
                    sound.play().catch(() => {});
                }
                latestIds = items.map(n => n.id);
            } catch (e) {
                // silent fail
            }
        }

        fetchNotifications(false);
        setInterval(() => fetchNotifications(true), 20000);

        notifToggle?.addEventListener('click', async () => {
            notifPanel.classList.toggle('hidden');
            if (!notifPanel.classList.contains('hidden') && latestIds.length) {
                await markReadAction();
            }
        });

        const markReadAction = async () => {
            try {
                await fetch('{{ route('notifications.read') }}', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                    body: JSON.stringify({ ids: latestIds })
                });
                notifList.innerHTML = '<div class="text-xs text-slate-400">No new notifications</div>';
                notifCount.classList.add('hidden');
                latestIds = [];
            } catch (e) {}
        };

        markRead?.addEventListener('click', markReadAction);
    })();
</script>
@endpush
