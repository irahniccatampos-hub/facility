<?php

namespace App\Policies;

use App\Models\Facility;
use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    public function create(User $user, Facility $facility): bool
    {
        return $facility->is_active;
    }

    public function update(User $user, Reservation $reservation): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $reservation->user_id === $user->id && $reservation->status === Reservation::STATUS_PENDING;
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $reservation->user_id === $user->id
            && !in_array($reservation->status, [Reservation::STATUS_CANCELLED, Reservation::STATUS_REJECTED], true);
    }

    public function approve(User $user, Reservation $reservation): bool
    {
        return $user->isAdmin() && $reservation->status === Reservation::STATUS_PENDING;
    }
}
