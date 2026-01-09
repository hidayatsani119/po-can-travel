<?php

namespace Database\Seeders;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $trips = [
            [
                'bus_id' => 1,
                'route_id' => 1,
                'departure_time' => Carbon::now()->addDays(1)->setTime(8, 0, 0),
                'arrival_time' => Carbon::now()->addDays(1)->setTime(11, 0, 0),
                'price' => 150000,
                'available_seats' => 40,
                'status' => 'scheduled',
            ],
            [
                'bus_id' => 2,
                'route_id' => 2,
                'departure_time' => Carbon::now()->addDays(1)->setTime(20, 0, 0),
                'arrival_time' => Carbon::now()->addDays(2)->setTime(6, 0, 0),
                'price' => 300000,
                'available_seats' => 35,
                'status' => 'scheduled',
            ],
            [
                'bus_id' => 3,
                'route_id' => 3,
                'departure_time' => Carbon::now()->addDays(2)->setTime(10, 0, 0),
                'arrival_time' => Carbon::now()->addDays(2)->setTime(22, 0, 0),
                'price' => 250000,
                'available_seats' => 45,
                'status' => 'scheduled',
            ],
            [
                'bus_id' => 1,
                'route_id' => 4,
                'departure_time' => Carbon::now()->addDays(3)->setTime(14, 0, 0),
                'arrival_time' => Carbon::now()->addDays(3)->setTime(16, 0, 0),
                'price' => 80000,
                'available_seats' => 40,
                'status' => 'scheduled',
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}
