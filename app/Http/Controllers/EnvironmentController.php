<?php

namespace App\Http\Controllers;

use App\Models\{Terrain, Vehicle};

class EnvironmentController
{
    public function prepare()
    {
        // Generates a new terrain with randomly placed obstacles
        $terrain = new Terrain(width: 35, height: 10);

        // Gets a safe location to place vehicle
        $coords = $terrain->getRandomLocation();

        // Creates a new vehicle and places it on available coordinates
        $vehicle = new Vehicle(
            $coords['latitude'],
            $coords['longitude'],
            Vehicle::ORIENTATIONS[array_rand(Vehicle::ORIENTATIONS, 1)]
        );

        return [$terrain, $vehicle];
    }
}
