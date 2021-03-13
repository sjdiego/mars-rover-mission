<?php

namespace App\Models\Movements;

use App\Models\Vehicle;

class Left extends Movement
{
    public function __construct(Vehicle &$vehicle)
    {
        $this->latitude = match($vehicle->orientation) {
            'W' => $vehicle->latitude + 1,
            'E' => $vehicle->latitude - 1,
            default => $vehicle->latitude
        };

        $this->longitude = match($vehicle->orientation) {
            'N' => $vehicle->longitude - 1,
            'S' => $vehicle->longitude + 1,
            default => $vehicle->longitude
        };

        $this->orientation = match($vehicle->orientation) {
            'N' => 'W',
            'S' => 'E',
            'W' => 'S',
            'E' => 'N',
            default => $vehicle->orientation
        };
    }
}
