<?php

namespace App\Models\Movements;

use App\Models\Vehicle;

abstract class Movement
{
    public int $latitude;
    public int $longitude;
    public string $orientation;

    public function get()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'orientation' => $this->orientation,
        ];
    }
}
