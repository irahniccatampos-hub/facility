<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class ReservationStatusChangedNotification extends Notification
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
            'title' => 'Reservation update',
            'message' => "Your reservation for {$this->reservation->facility->name} was {$this->reservation->status}.",
            'reservation_id' => $this->reservation->id,
            'status' => $this->reservation->status,
            'facility' => $this->reservation->facility->only(['id', 'name']),
        ]);
    }
}
