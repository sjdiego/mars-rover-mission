<?php

namespace App\Http\Controllers;

use App\Models\{Command, Terrain, Vehicle};

class VehicleController
{
    public Terrain $terrain;
    public Vehicle $vehicle;

    public function __construct(Terrain $terrain, Vehicle $vehicle) {
        $this->terrain = $terrain;
        $this->vehicle = $vehicle;
    }

    public function executeCommands(string $commands)
    {
        $path = [];

        collect(str_split($commands))->each(function ($code) use (&$path) {
            $command = new Command($code);
            $nextCoords = $this->vehicle->getCoordsFromCommand($command);

            if (!$this->checkPosition($nextCoords)) {
                throw new \Exception(__('messages.colission.detected', [
                    'obstacle' => implode(',', $nextCoords),
                    'safePosition' => implode(',', [
                        $this->vehicle->latitude,
                        $this->vehicle->longitude,
                    ])
                ]));

                return false;
            }

            $this->vehicle->latitude = $nextCoords['latitude'];
            $this->vehicle->longitude = $nextCoords['longitude'];
            $this->vehicle->orientation = $nextCoords['orientation'];

            $path[] = $nextCoords;
        });

        return $path;
    }

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
