<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company() . ' Room',
            'description' => fake()->sentence(),
            'type' => fake()->randomElement(['Conference', 'Meeting', 'Training', 'Auditorium']),
            'location' => fake()->city(),
            'is_active' => true,
            'thumbnail_url' => 'images/facilities/default.jpg',
            'latitude' => fake()->randomFloat(6, 6.7300, 6.7700), // around Digos City
            'longitude' => fake()->randomFloat(6, 125.3400, 125.3800),
        ];
    }
}
