const initNotificationBell = () => {
    const container = document.getElementById('notif-bell');
    if (!container || !window.axios) return;

    const toggleBtn = container.querySelector('[data-notif-toggle]');
    const dropdown = container.querySelector('#notif-dropdown');
    const countBadge = container.querySelector('#notif-count');
    const list = container.querySelector('#notif-list');
    const loading = container.querySelector('#notif-loading');
    const markAllBtn = container.querySelector('[data-notif-mark-all]');

    let isOpen = false;
    let notifications = [];

    const setBadge = (count) => {
        if (!countBadge) return;
        const safeCount = Number(count) || 0;
        if (safeCount > 0) {
            countBadge.textContent = safeCount;
            countBadge.classList.remove('hidden');
        } else {
            countBadge.classList.add('hidden');
        }
    };

    const setLoading = (state) => {
        if (!list || !loading) return;
        if (state) {
            list.innerHTML = '';
            loading.classList.remove('hidden');
            list.appendChild(loading);
        } else {
            loading.classList.add('hidden');
        }
    };

    const closeDropdown = () => {
        if (!dropdown) return;
        dropdown.classList.add('hidden');
        isOpen = false;
        toggleBtn?.setAttribute('aria-expanded', 'false');
    };

    const renderNotifications = () => {
        if (!list) return;
        list.innerHTML = '';

        if (!notifications.length) {
            const empty = document.createElement('div');
            empty.className = 'p-4 text-sm text-slate-500 text-center';
            empty.textContent = 'No notifications yet.';
            list.appendChild(empty);
            return;
        }

        notifications.forEach((notification) => {
            const item = document.createElement('div');
            item.setAttribute('role', 'button');
            item.tabIndex = 0;
            item.dataset.notifItem = notification.id;
            item.className = `p-4 flex gap-3 hover:bg-slate-50 cursor-pointer ${notification.read_at ? 'bg-white' : 'bg-slate-50'}`;

            const dot = document.createElement('div');
            dot.className = `flex-shrink-0 w-2 h-2 mt-2 rounded-full ${notification.read_at ? 'bg-slate-300' : 'bg-emerald-500'}`;

            const content = document.createElement('div');
            content.className = 'flex-1';

            const title = document.createElement('div');
            title.className = 'text-sm font-semibold text-slate-900';
            title.textContent = notification?.data?.title ?? 'Notification';

            const body = document.createElement('div');
            body.className = 'text-sm text-slate-600 mt-1';
            body.textContent = notification?.data?.body ?? '';

            const meta = document.createElement('div');
            meta.className = 'text-xs text-slate-500 mt-1';
            meta.textContent = notification.created_human ?? '';

            content.appendChild(title);
            content.appendChild(body);
            content.appendChild(meta);

            item.appendChild(dot);
            item.appendChild(content);

            const url = notification?.data?.meta?.url ?? null;

            const handleActivate = () => {
                const goToMeta = () => {
                    if (url) {
                        window.location.href = url;
                    }
                };

                if (notification.read_at) {
                    goToMeta();
                    return;
                }

                markNotificationRead(notification.id, goToMeta);
            };

            item.addEventListener('click', handleActivate);
            item.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    handleActivate();
                }
            });

            list.appendChild(item);
        });
    };

    const fetchNotifications = async () => {
        try {
            setLoading(true);
            const { data } = await window.axios.get('/notifications');
            notifications = data?.notifications ?? [];
            setBadge(data?.unread_count ?? 0);
            renderNotifications();
        } catch (error) {
            console.error('Failed to fetch notifications', error);
        } finally {
            setLoading(false);
        }
    };

    const markNotificationRead = async (id, onDone) => {
        if (!id) return;
        try {
            await window.axios.post(`/notifications/${id}/read`);
            await fetchNotifications();
        } catch (error) {
            console.error('Failed to mark notification as read', error);
        } finally {
            if (typeof onDone === 'function') {
                onDone();
            }
        }
    };

    const markAllRead = async () => {
        if (!notifications.length) return;
        try {
            await window.axios.post('/notifications/read-all');
            await fetchNotifications();
        } catch (error) {
            console.error('Failed to mark all notifications as read', error);
        }
    };

    const openDropdown = async () => {
        if (!dropdown) return;
        dropdown.classList.remove('hidden');
        isOpen = true;
        toggleBtn?.setAttribute('aria-expanded', 'true');
        await fetchNotifications();
    };

    const toggleDropdown = async () => {
        if (isOpen) {
            closeDropdown();
        } else {
            await openDropdown();
        }
    };

    toggleBtn?.addEventListener('click', () => toggleDropdown());
    toggleBtn?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            toggleDropdown();
        }
    });

    markAllBtn?.addEventListener('click', markAllRead);
    markAllBtn?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            markAllRead();
        }
    });

    document.addEventListener('click', (event) => {
        if (isOpen && container && !container.contains(event.target)) {
            closeDropdown();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (isOpen && event.key === 'Escape') {
            closeDropdown();
        }
    });

    setBadge(container.dataset.unread ?? 0);

    window.notificationBell = {
        refresh: fetchNotifications,
    };
};

document.addEventListener('DOMContentLoaded', initNotificationBell);
