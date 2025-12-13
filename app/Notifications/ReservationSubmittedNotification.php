<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class ReservationSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Reservation $reservation)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'title' => 'New reservation submitted',
            'message' => "{$this->reservation->user->name} requested {$this->reservation->facility->name} from {$this->reservation->start_time} to {$this->reservation->end_time}.",
            'reservation_id' => $this->reservation->id,
            'status' => $this->reservation->status,
            'user' => $this->reservation->user->only(['id', 'name', 'email']),
            'facility' => $this->reservation->facility->only(['id', 'name']),
        ]);
    }
}
