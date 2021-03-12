<?php

namespace App\Models;

class Terrain
{
    const OBSTACLE_PROBABLITY = 0.03;

    public array $surface;

    public function __construct(int $width = 45, int $height = 15)
    {
        $this->width = $width;
        $this->height = $height;

        for ($i = 1; $i <= $height; $i++) {
            for ($j = 1; $j <= $width; $j++) {
                $this->surface[$i][$j] = (int) (random_int(0, 100) / 100 <= self::OBSTACLE_PROBABLITY);
            }
        }
    }

    /**
     * Finds a location free of obstacles
     *
     * @return array
     */
    public function getRandomLocation(): array
    {
        do {
            $latitude = random_int(1, $this->height);
            $longitude = random_int(1, $this->width);
        } while ($this->surface[$latitude][$longitude] === 1);

        return compact('latitude', 'longitude');
    }
}
