<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationBell extends Component
{
    public bool $open = false;

    #[Computed]
    public function notifications(): Collection
    {
        $user = Auth::user();

        return $user?->notifications()
            ->latest()
            ->limit(10)
            ->get() ?? collect();
    }

    #[Computed]
    public function unreadCount(): int
    {
        $user = Auth::user();

        return $user?->unreadNotifications()->count() ?? 0;
    }

    public function toggle(): void
    {
        $this->open = !$this->open;
    }

    #[On('notification-received')]
    public function refreshNotifications(): void
    {
        $this->dispatch('$refresh');
    }

    public function markAsRead(?string $notificationId = null): void
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        $query = $user->notifications();

        if ($notificationId) {
            $query->where('id', $notificationId);
        } else {
            $query->whereNull('read_at');
        }

        $query->update(['read_at' => now()]);

        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
