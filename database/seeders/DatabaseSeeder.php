<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'role' => User::ROLE_ADMIN,
                'password' => 'password', // hashed via cast
                'avatar_url' => 'images/avatars/admin.jpg',
            ]
        );

        // Demo users
        $avatarSet = [
            'images/avatars/user1.jpg',
            'images/avatars/user2.jpg',
            'images/avatars/user3.jpg',
            'images/avatars/user4.jpg',
            'images/avatars/user5.jpg',
        ];

        $users = collect();
        foreach ($avatarSet as $index => $avatarUrl) {
            $users->push(
                User::updateOrCreate(
                    ['email' => "user".($index + 1)."@example.com"],
                    [
                        'name' => fake()->name(),
                        'role' => User::ROLE_USER,
                        'password' => 'password',
                        'avatar_url' => $avatarUrl,
                    ]
                )
            );
        }
        $users = $users->values();

        // Demo facilities
        $facilityPresets = [
            [
                'name' => 'Digos Bay Inn',
                'type' => 'Lodging / Inn',
                'location' => 'Roxas Ext, Digos City, Davao del Sur',
                'thumbnail_url' => asset('images/facilities/digos-bay-inn.jpg'),
                'latitude' => 6.7492,
                'longitude' => 125.3579,
            ],
            [
                'name' => 'South Ridge Fitness',
                'type' => 'Gym / Fitness Center',
                'location' => 'Quirino Ave, Digos City, Davao del Sur',
                'thumbnail_url' => asset('images/facilities/south-ridge-fitness.jpg'),
                'latitude' => 6.7475,
                'longitude' => 125.3551,
            ],
            [
                'name' => 'Digos City Library',
                'type' => 'Library',
                'location' => 'Rizal Ave, Digos City, Davao del Sur',
                'thumbnail_url' => asset('images/facilities/digos-library.jpg'),
                'latitude' => 6.7510,
                'longitude' => 125.3520,
            ],
            [
                'name' => 'Mindanao Labs - Digos',
                'type' => 'Laboratory',
                'location' => 'National Highway, Digos City, Davao del Sur',
                'thumbnail_url' => asset('images/facilities/mindanao-labs.jpg'),
                'latitude' => 6.7462,
                'longitude' => 125.3490,
            ],
            [
                'name' => 'Mt. Apo View Lodge',
                'type' => 'Lodging / Inn',
                'location' => 'Jose Abad Santos St, Digos City, Davao del Sur',
                'thumbnail_url' => asset('images/facilities/mt-apo-view-lodge.jpg'),
                'latitude' => 6.7535,
                'longitude' => 125.3555,
            ],
        ];

        $facilities = collect();
        foreach ($facilityPresets as $preset) {
            $facilities->push(
                Facility::updateOrCreate(
                    ['name' => $preset['name']],
                    [
                        'description' => $preset['name'].' description',
                        'location' => $preset['location'],
                        'is_active' => true,
                        'thumbnail_url' => $preset['thumbnail_url'],
                        'type' => $preset['type'],
                        'latitude' => $preset['latitude'],
                        'longitude' => $preset['longitude'],
                    ]
                )
            );
        }
        $facilities = $facilities->values();

        // Seed at least 5 demo reservations with non-overlapping slots
        $startDay = Carbon::now()->addDay()->startOfDay();
        foreach (range(0, 4) as $index) {
            $start = (clone $startDay)->addDays($index)->setHour(9)->setMinute(0);
            $end = (clone $start)->addHours(2);

            Reservation::create([
                'user_id' => $users[$index % $users->count()]->id,
                'facility_id' => $facilities[$index]->id,
                'start_time' => $start,
                'end_time' => $end,
                'status' => Reservation::STATUS_APPROVED,
                'reason' => 'Demo booking',
            ]);
        }
    }
}
