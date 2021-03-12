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

    public function runCommand(Command $command, Terrain $terrain)
    {
        $coords = match(mb_strtoupper($command->command)) {
            'F' => $this->moveForward(),
            'R' => $this->moveRight(),
            'L' => $this->moveLeft(),
        };

        return $coords;
    }

    protected function moveForward()
    {
        return match($this->orientation) {
            'N' => ['lat' => --$this->latitude, 'lng' => $this->longitude],
            'S' => ['lat' => ++$this->latitude, 'lng' => $this->longitude],
            'W' => ['lat' => --$this->longitude, 'lng' => $this->latitude],
            'E' => ['lat' => ++$this->longitude, 'lng' => $this->latitude],
        };
    }

    protected function moveRight()
    {
        return match ($this->orientation) {
            'N' => ['lat' => $this->latitude, 'lng' => --$this->longitude],
            'S' => ['lat' => $this->latitude, 'lng' => ++$this->longitude],
            'W' => ['lat' => $this->longitude, 'lng' => --$this->latitude],
            'E' => ['lat' => $this->longitude, 'lng' => ++$this->latitude],
        };
    }

    protected function moveLeft()
    {
        return match ($this->orientation) {
            'N' => ['lat' => $this->latitude, 'lng' => ++$this->longitude],
            'S' => ['lat' => $this->latitude, 'lng' => --$this->longitude],
            'W' => ['lat' => $this->longitude, 'lng' => ++$this->latitude],
            'E' => ['lat' => $this->longitude, 'lng' => --$this->latitude],
        };
    }
}
