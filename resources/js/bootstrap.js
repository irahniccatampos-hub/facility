import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const csrfToken = document.head.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}

window.Pusher = Pusher;

const currentUserMeta = document.head.querySelector('meta[name="user-id"]');

if (currentUserMeta && import.meta.env.VITE_PUSHER_APP_KEY) {
    const cluster = import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1';
    const host = import.meta.env.VITE_PUSHER_HOST ?? `ws-${cluster}.pusher.com`;
    const port = Number(import.meta.env.VITE_PUSHER_PORT ?? 443);
    const scheme = import.meta.env.VITE_PUSHER_SCHEME ?? 'https';

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster,
        wsHost: host,
        wsPort: port,
        wssPort: port,
        forceTLS: scheme === 'https',
        encrypted: scheme === 'https',
        disableStats: true,
        enabledTransports: ['ws', 'wss'],
    });

    window.Echo.private(`App.Models.User.${currentUserMeta.content}`)
        .notification((notification) => {
            if (window.notificationBell?.refresh) {
                window.notificationBell.refresh();
            }
            if (window.Livewire) {
                window.Livewire.dispatch('notification-received', { notification });
            }
        });
}
