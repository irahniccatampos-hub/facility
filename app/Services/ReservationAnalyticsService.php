<?php

namespace App\Services;

use App\Models\Facility;
use App\Models\Reservation;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class ReservationAnalyticsService
{
    public function facilityUsage(?CarbonInterface $from = null, ?CarbonInterface $to = null): Collection
    {
        $query = Reservation::query()
            ->selectRaw('facility_id, SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as hours')
            ->where('status', Reservation::STATUS_APPROVED)
            ->groupBy('facility_id');

        if ($from) {
            $query->where('start_time', '>=', $from);
        }

        if ($to) {
            $query->where('end_time', '<=', $to);
        }

        $usage = $query->get()->keyBy('facility_id');

        $facilityNames = Facility::pluck('name', 'id');

        return $facilityNames->map(function ($name, $id) use ($usage) {
            return [
                'facility_id' => $id,
                'facility_name' => $name,
                'hours' => (float) ($usage[$id]->hours ?? 0),
            ];
        })->values();
    }

    public function peakHours(?CarbonInterface $from = null, ?CarbonInterface $to = null): Collection
    {
        $query = Reservation::query()
            ->selectRaw('HOUR(start_time) as hour, COUNT(*) as total')
            ->where('status', Reservation::STATUS_APPROVED)
            ->groupBy('hour');

        if ($from) {
            $query->where('start_time', '>=', $from);
        }

        if ($to) {
            $query->where('end_time', '<=', $to);
        }

        return $query->orderBy('hour')->get()->map(fn ($row) => [
            'hour' => (int) $row->hour,
            'total' => (int) $row->total,
        ]);
    }
}
