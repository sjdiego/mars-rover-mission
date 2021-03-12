<?php

namespace App\Console\Commands;

use App\Models\Command as RoverCommand;
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
            list($terrain, $vehicle) = $this->prepareEnvironment();

            $this->handleCommands($terrain, $vehicle);
        } catch (\Exception $e) {
            $this->error($e);
        }
    }

    /**
     * It generates a terrain with randomly placed obstacles and puts in the vehicle
     *
     * @return array
     */
    protected function prepareEnvironment(): array
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
        $this->newLine();
        $this->comment(sprintf(
            'The vehicle has been placed on latitude %d and longitude %d with a %s orientation.',
            $vehicle->latitude, $vehicle->longitude, $vehicle->orientation
        ));
        $this->newLine();

        // Draws terrain with obstacles and placed vehicle in console
        $this->drawTerrain($terrain, $vehicle);
        $this->newLine();

        return [$terrain, $vehicle];
    }

    protected function handleCommands(Terrain $terrain, Vehicle $vehicle)
    {
        $this->newLine();

        do {
            $typedCommands = $this->ask('Please type here the commands to send to the vehicle');
        } while (!strlen($typedCommands));

        foreach (str_split($typedCommands) as $code) {
            $cmd = new RoverCommand($code);
            $vehicle->runCommand($cmd, $terrain);

            $this->comment(sprintf(
                'The vehicle has been displaced to %d,%d',
                $vehicle->latitude, $vehicle->longitude
            ));
        }

        $this->newLine();
        $this->info(sprintf('The sequence \'%s\' has been executed successfully.', $typedCommands));
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

                echo $vehiclePlacement ? $vehicle->orientation : ($terrain->surface[$i][$j] === 0 ? '.' : 'X');
                echo ($j === count($terrain->surface[$i])) ? "|" . PHP_EOL : '';
            }
        }

        echo str_pad('', count($terrain->surface[1]) + 2, '-') . PHP_EOL;
    }
}
