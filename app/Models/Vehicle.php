<?php

namespace App\Models;

class Vehicle
{
    const ORIENTATIONS = ['N', 'S', 'E', 'W'];

    public function __construct(
        public int $latitude,
        public int $longitude,
        public string $orientation
    ) {
        if (!in_array($orientation, self::ORIENTATIONS)) {
            throw new \Exception("Orientation ${orientation} is not available.");
        }
    }
}
