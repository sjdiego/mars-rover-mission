<?php

namespace App\Console\Commands;

use App\Models\Command as ModelsCommand;
use App\Models\Terrain;
use App\Models\Vehicle;
use Illuminate\Console\Command;

class Rover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a sequence of commands to execute to Rover vehicle';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->prepareEnvironment();
            $this->handleCommands();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * It generates a terrain with randomly placed obstacles and puts in the vehicle
     *
     * @return void
     */
    protected function prepareEnvironment(): void
    {
        $this->info('Mars Rover Mission v1');
        $this->newLine(1);

        // Generates a new terrain with randomly placed
        $terrain = new Terrain();

        // Gets available location to place vehicle
        $coords = $terrain->getRandomLocation();

        // Creates a new vehicle and places it on available coordinates
        $vehicle = new Vehicle(
            $coords['latitude'],
            $coords['longitude'],
            Vehicle::ORIENTATIONS[array_rand(Vehicle::ORIENTATIONS, 1)]
        );

        // Display data of generated data
        $this->comment('A terrain with randomly placed obstacles has been generated automatically.');
        $this->comment(sprintf('The surface has %d blocks of width and %d blocks of height.', $terrain->width, $terrain->height));
        $this->newLine(1);
        $this->comment(sprintf(
            'The vehicle has been placed on row %d and column %d with a orientation of %s.',
            $vehicle->latitude, $vehicle->longitude, $vehicle->orientation
        ));
        $this->newLine(1);

        // Draws terrain with obstacles and placed vehicle in console
        $this->drawTerrain($terrain, $vehicle);
    }

    protected function handleCommands()
    {
        $typedCommands = $this->ask('Please type here the commands to send to the vehicle:');
    }

    /**
     * It draws a representation of the surface's terrain with a placed Vehicle
     *
     * @param Terrain $terrain
     * @param Vehicle $vehicle
     *
     * @return void
     */
    protected function drawTerrain(Terrain $terrain, Vehicle $vehicle)
    {
        echo str_pad('', count($terrain->surface[1]) + 2, '-') . PHP_EOL;

        for ($i = 1; $i <= count($terrain->surface); $i++) {
            for ($j = 1; $j <= count($terrain->surface[$i]); $j++) {
                echo (1 === $j) ? '|' : '';

                $vehiclePlacement = ($j === $vehicle->longitude && $i === $vehicle->latitude);

                echo $vehiclePlacement ? $vehicle->orientation : ($terrain->surface[$i][$j] === 0 ? ' ' : 'X');
                echo ($j === count($terrain->surface[$i])) ? "|" . PHP_EOL : '';
            }
        }

        echo str_pad('', count($terrain->surface[1]) + 2, '-') . PHP_EOL;
    }
}
