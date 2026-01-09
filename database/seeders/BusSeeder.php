<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $buses = [
            [
                'name' => 'Luxury Coach',
                'plate_number' => 'B 1234 AB',
                'type' => 'AC',
                'total_seats' => 40,
                'facilities' => json_encode(['AC', 'TV', 'Toilet', 'WiFi', 'Snack']),
                'status' => 'active',
            ],
            [
                'name' => 'Executive Bus',
                'plate_number' => 'B 5678 CD',
                'type' => 'AC',
                'total_seats' => 35,
                'facilities' => json_encode(['AC', 'TV', 'Toilet', 'WiFi']),
                'status' => 'active',
            ],
            [
                'name' => 'Economy Bus',
                'plate_number' => 'B 9012 EF',
                'type' => 'Non-AC',
                'total_seats' => 45,
                'facilities' => json_encode(['Toilet']),
                'status' => 'active',
            ],
        ];

        foreach ($buses as $bus) {
            Bus::create($bus);
        }
    }
}
