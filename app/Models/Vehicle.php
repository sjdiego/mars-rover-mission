<?php

namespace App\Models;

use App\Models\Movements\{Forward, Left, Right};

/**
 * Class that manages data related to Rover vehicle
 */
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

    /**
     * Gets coordinates of next position from received Command
     *
     * @param Command $command
     * @return mixed
     */
    public function getCoordsFromCommand(Command $command): mixed
    {
        return match(mb_strtoupper($command->command)) {
            'F' => (new Forward($this))->get(),
            'R' => (new Right($this))->get(),
            'L' => (new Left($this))->get(),
            default => false,
        };
    }

    /**
     * Changes latitude of Vehicle
     *
     * @param integer $latitude
     * @return void
     */
    public function setLatitude(int $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * Changes longitude of Vehicle
     *
     * @param integer $longitude
     * @return void
     */
    public function setLongitude(int $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * Changes orientation of Vehicle
     *
     * @param string $orientation
     * @return void
     */
    public function setOrientation(string $orientation): void
    {
        $this->orientation = $orientation;
    }
}
