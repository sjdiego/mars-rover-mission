<?php

namespace App\Models\Movements;

use App\Models\Vehicle;

class Forward extends Movement
{
    public function __construct(Vehicle $vehicle)
    {
        $this->latitude = match ($vehicle->orientation) {
            'N' => $vehicle->latitude - 1,
            'S' => $vehicle->latitude + 1,
            default => $vehicle->latitude
        };

        $this->longitude = match ($vehicle->orientation) {
            'W' => $vehicle->longitude - 1,
            'E' => $vehicle->longitude + 1,
            default => $vehicle->longitude
        };

        $this->orientation = $vehicle->orientation;
    }
}
