<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\CarbonInterface;

class ReservationConflictService
{
    /**
     * Check for overlapping reservations on a facility.
     *
     * By default only approved reservations block new ones. Pass additional
     * statuses (e.g. pending) to also soft-block overlapping requests.
     */
    public function hasConflict(
        int $facilityId,
        CarbonInterface $start,
        CarbonInterface $end,
        ?int $ignoreReservationId = null,
        array $statuses = [Reservation::STATUS_APPROVED]
    ): bool
    {
        return Reservation::where('facility_id', $facilityId)
            ->whereIn('status', $statuses)
            ->when($ignoreReservationId, fn ($query) => $query->where('id', '!=', $ignoreReservationId))
            ->where(function ($query) use ($start, $end) {
                $query->where('start_time', '<', $end)
                    ->where('end_time', '>', $start);
            })
            ->exists();
    }
}
