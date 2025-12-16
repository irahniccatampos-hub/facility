<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\User;
use App\Notifications\RealtimeNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class ReservationNotificationService
{
    public function notifyAdminsOfNewReservation(Reservation $reservation): void
    {
        $admins = User::where('role', User::ROLE_ADMIN)->get();
        if ($admins->isEmpty()) {
            return;
        }

        $facilityName = $reservation->facility->name ?? 'Facility';
        $timeslot = $this->formatTimeslot($reservation);
        $requestor = $reservation->user->name ?? 'A user';

        Notification::send(
            $admins,
            new RealtimeNotification(
                title: 'New reservation request',
                body: "{$requestor} requested {$facilityName} for {$timeslot}.",
                meta: [
                    'type' => 'reservation_request',
                    'reservation_id' => $reservation->id,
                    'facility_id' => $reservation->facility_id,
                    'user_id' => $reservation->user_id,
                    'status' => $reservation->status,
                    'url' => route('admin.reservations.pending'),
                ],
            )
        );
    }

    public function notifyUserOfDecision(Reservation $reservation): void
    {
        $user = $reservation->user;
        if (!$user) {
            return;
        }

        $facilityName = $reservation->facility->name ?? 'Facility';
        $timeslot = $this->formatTimeslot($reservation);

        if ($reservation->isApproved()) {
            $title = 'Reservation approved';
            $body = "Your reservation for {$facilityName} on {$timeslot} has been approved.";
        } elseif ($reservation->status === Reservation::STATUS_REJECTED) {
            $title = 'Reservation rejected';
            $reason = $reservation->reason ? ' Reason: ' . $reservation->reason : '';
            $body = "Your reservation for {$facilityName} on {$timeslot} was rejected.{$reason}";
        } else {
            return;
        }

        $user->notify(new RealtimeNotification(
            title: $title,
            body: $body,
            meta: [
                'type' => 'reservation_status',
                'reservation_id' => $reservation->id,
                'facility_id' => $reservation->facility_id,
                'user_id' => $reservation->user_id,
                'status' => $reservation->status,
                'url' => route('user.reservations.index'),
            ],
        ));
    }

    private function formatTimeslot(Reservation $reservation): string
    {
        if (!$reservation->start_time || !$reservation->end_time) {
            return 'the selected schedule';
        }

        $start = $reservation->start_time instanceof Carbon
            ? $reservation->start_time
            : Carbon::parse($reservation->start_time);
        $end = $reservation->end_time instanceof Carbon
            ? $reservation->end_time
            : Carbon::parse($reservation->end_time);

        return $start->timezone(config('app.timezone'))->format('M d, Y g:ia')
            . ' - '
            . $end->timezone(config('app.timezone'))->format('g:ia');
    }
}
