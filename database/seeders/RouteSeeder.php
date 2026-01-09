<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $routes = [
            [
                'departure_city' => 'Jakarta',
                'departure_terminal' => 'Pulo Gadung',
                'arrival_city' => 'Bandung',
                'arrival_terminal' => 'Leuwi Panjang',
                'distance' => 150,
                'estimated_duration' => 180,
            ],
            [
                'departure_city' => 'Jakarta',
                'departure_terminal' => 'Pulo Gadung',
                'arrival_city' => 'Yogyakarta',
                'arrival_terminal' => 'Giwoyo',
                'distance' => 550,
                'estimated_duration' => 600,
            ],
            [
                'departure_city' => 'Bandung',
                'departure_terminal' => 'Leuwi Panjang',
                'arrival_city' => 'Surabaya',
                'arrival_terminal' => 'Purabaya',
                'distance' => 700,
                'estimated_duration' => 720,
            ],
            [
                'departure_city' => 'Surabaya',
                'departure_terminal' => 'Purabaya',
                'arrival_city' => 'Malang',
                'arrival_terminal' => 'Arjosari',
                'distance' => 90,
                'estimated_duration' => 120,
            ],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
