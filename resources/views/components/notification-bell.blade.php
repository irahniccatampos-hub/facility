@php
    $user = auth()->user();
    $notifications = $user?->notifications()->latest()->limit(10)->get() ?? collect();
    $unreadCount = $user?->unreadNotifications()->count() ?? 0;
@endphp

<div class="relative" id="notif-bell" data-unread="{{ $unreadCount }}" aria-haspopup="true">
    <div role="button"
         tabindex="0"
         aria-expanded="false"
         class="relative flex items-center justify-center w-10 h-10 rounded-full bg-slate-800 text-white hover:bg-slate-700 transition cursor-pointer"
         data-notif-toggle>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @if ($unreadCount > 0)
            <span id="notif-count" class="absolute -top-1 -right-1 min-w-[1.4rem] px-1.5 py-0.5 text-[10px] font-semibold leading-none text-white bg-red-600 rounded-full text-center">
                {{ $unreadCount }}
            </span>
        @else
            <span id="notif-count" class="hidden"></span>
        @endif
    </div>

    <div id="notif-dropdown" class="hidden absolute right-0 mt-3 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 overflow-hidden">
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
            <span class="text-sm font-semibold text-slate-800">Notifications</span>
            <div role="button"
                 tabindex="0"
                 class="text-xs font-medium text-blue-600 hover:text-blue-700 cursor-pointer"
                 data-notif-mark-all>
                Mark all read
            </div>
        </div>
        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100" id="notif-list">
            <div id="notif-loading" class="hidden p-4 text-sm text-slate-500 text-center">Loading...</div>
            @forelse ($notifications as $notification)
                @php($data = $notification->data ?? [])
                <div role="button"
                     tabindex="0"
                     data-notif-item="{{ $notification->id }}"
                     class="p-4 flex gap-3 hover:bg-slate-50 cursor-pointer {{ $notification->read_at ? 'bg-white' : 'bg-slate-50' }}">
                    <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full {{ $notification->read_at ? 'bg-slate-300' : 'bg-emerald-500' }}"></div>
                    <div class="flex-1">
                        <div class="text-sm font-semibold text-slate-900">{{ $data['title'] ?? 'Notification' }}</div>
                        <div class="text-sm text-slate-600 mt-1">{{ $data['body'] ?? '' }}</div>
                        <div class="text-xs text-slate-500 mt-1">
                            {{ optional($notification->created_at)->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-sm text-slate-500 text-center" data-notif-empty>
                    No notifications yet.
                </div>
            @endforelse
        </div>
    </div>
</div>
