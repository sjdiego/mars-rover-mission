<?php

namespace App\Http\Controllers;

use App\Models\{Terrain, Vehicle};

/**
 * Class that manages the fictional environment on Mars
 */
class EnvironmentController
{
    /**
     * It returns an array with a Terrain and a placed Vehicle
     *
     * @return array
     */
    public function prepare(): array
    {
        // Generates a new terrain with randomly placed obstacles
        $terrain = new Terrain(width: 60, height: 20);

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
