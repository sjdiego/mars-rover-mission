<?php

namespace App\Http\Controllers;

use App\Models\{Command, Terrain, Vehicle};

/**
 * Class that manages a Vehicle on Terrain
 */
class VehicleController
{
    public Terrain $terrain;
    public Vehicle $vehicle;

    /**
     * Contructor which adds a Vehicle with data of Terrain
     *
     * @param Terrain $terrain
     * @param Vehicle $vehicle
     */
    public function __construct(Terrain $terrain, Vehicle $vehicle) {
        $this->terrain = $terrain;
        $this->vehicle = $vehicle;
    }

    /**
     * It executes commands on vehicle and returns a path
     * with movements done by Vehicle over Terrain
     *
     * @param string $commands
     * @return array
     */
    public function executeCommands(string $commands): array
    {
        $path = [];

        collect(str_split($commands))->each(function ($code) use (&$path) {
            /** Creates command for each character */
            $command = new Command($code);

            /** Get next coordinates of command to make a displacement */
            $nextCoords = $this->vehicle->getCoordsFromCommand($command);

            /** Check if next coordinates are safe to move or there is an obstacle */
            if (!$this->checkPosition($nextCoords)) {
                $exceptionInfo = [
                    'obstacle' => implode(',', $nextCoords),
                    'safePosition' => implode(',', [$this->vehicle->latitude, $this->vehicle->longitude])
                ];

                throw new \Exception(__('messages.colission.detected', $exceptionInfo));
            }

            /** Perform the movement of the Vehicle */
            $this->vehicle->setLatitude($nextCoords['latitude']);
            $this->vehicle->setLongitude($nextCoords['longitude']);
            $this->vehicle->setOrientation($nextCoords['orientation']);

            /** Append coordinates to create a path */
            $path[] = $nextCoords;
        });

        return $path;
    }

    /**
     * It checks if position on provided coordinates is safe.
     * A position is safe if there are no obstacles or is
     * inside the boundaries of the Terrain's surface
     *
     * @param array $coords
     * @return boolean
     */
    protected function checkPosition(array $coords): bool
    {
        if (isset($this->terrain->surface[$coords['latitude']]) &&
            isset($this->terrain->surface[$coords['latitude']][$coords['longitude']])
        ) {
            return $this->terrain->surface[$coords['latitude']][$coords['longitude']] !== true;
        }

        // Out of terrain
        return false;
    }
}
