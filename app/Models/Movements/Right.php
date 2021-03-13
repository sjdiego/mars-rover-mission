<?php

namespace App\Models\Movements;

use App\Models\Vehicle;

class Right extends Movement
{
    public function __construct(Vehicle &$vehicle)
    {
        $this->latitude = match($vehicle->orientation) {
            'W' => $vehicle->latitude - 1,
            'E' => $vehicle->latitude + 1,
            default => $vehicle->latitude
        };

        $this->longitude = match($vehicle->orientation) {
            'N' => $vehicle->longitude + 1,
            'S' => $vehicle->longitude - 1,
            default => $vehicle->longitude
        };

        $this->orientation = match($vehicle->orientation) {
            'N' => 'E',
            'S' => 'W',
            'W' => 'N',
            'E' => 'S',
            default => $vehicle->orientation
        };
    }
}
