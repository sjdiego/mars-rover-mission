<?php

namespace App\Models;

/**
 * Class that manages data of Mars' surface
 */
class Terrain
{
    const OBSTACLE_PROBABLITY = 0.1;

    public array $surface;

    public function __construct(public int $width, public int $height) {
        $this->surface = collect(range(1, $height))
            ->map(fn () => collect(range(1, $width))
            ->map(fn () => random_int(0, 100) / 100 <= self::OBSTACLE_PROBABLITY))
            ->toArray();
    }

    /**
     * Finds a location free of obstacles
     *
     * @return array
     */
    public function getRandomLocation(): array
    {
        do {
            $latitude = random_int(0, $this->height - 1);
            $longitude = random_int(0, $this->width - 1);
        } while ($this->surface[$latitude][$longitude] !== false);

        return compact('latitude', 'longitude');
    }
}
