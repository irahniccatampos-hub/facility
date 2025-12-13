<?php

namespace Database\Factories;

use App\Models\Facility;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $start = Carbon::now()->addDays(fake()->numberBetween(1, 10))->setHour(fake()->numberBetween(8, 18))->setMinute(0);
        $end = (clone $start)->addHours(fake()->numberBetween(1, 3));

        return [
            'user_id' => User::factory(),
            'facility_id' => Facility::factory(),
            'start_time' => $start,
            'end_time' => $end,
            'status' => Reservation::STATUS_PENDING,
            'reason' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn () => ['status' => Reservation::STATUS_APPROVED]);
    }
}
