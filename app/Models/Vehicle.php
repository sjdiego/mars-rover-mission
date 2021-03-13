<?php

namespace App\Models;

use App\Models\Movements\{Forward, Left, Right};

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

    public function getCoordsFromCommand(Command $command)
    {
        return match(mb_strtoupper($command->command)) {
            'F' => (new Forward($this))->get(),
            'R' => (new Right($this))->get(),
            'L' => (new Left($this))->get(),
        };
    }
}
