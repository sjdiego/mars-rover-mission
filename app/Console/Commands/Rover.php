<?php

namespace App\Console\Commands;

use App\Http\Controllers\{EnvironmentController, VehicleController};
use App\Models\{Terrain, Vehicle};
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
            $this->error($e->getMessage());
        }
    }

    /**
     * It prepares the terrain with obstacles and puts a new vehicle in a safe place
     *
     * @return array
     */
    protected function prepareEnvironment(): array
    {
        $environment = new EnvironmentController();
        list($terrain, $vehicle) = $environment->prepare();

        // Display data of generated data
        $this->info('Mars Rover Mission v1');
        $this->newLine();
        $this->comment(__('messages.terrain.generated'));
        $this->comment(__('messages.terrain.surface.blocks', [
            'heigth' => $terrain->height,
            'width' => $terrain->width
        ]));
        $this->comment(__('messages.vehicle.placement', [
            'latitude' => $vehicle->latitude,
            'longitude' => $vehicle->longitude,
            'orientation' => $vehicle->orientation
        ]));
        $this->newLine();

        $this->drawTerrain($terrain, $vehicle);

        return [$terrain, $vehicle];
    }

    /**
     * It asks for commands and sends it to the Vehicle controller
     *
     * @param Terrain $terrain
     * @param Vehicle $vehicle
     *
     * @return void
     */
    protected function handleCommands(Terrain $terrain, Vehicle $vehicle)
    {
        $this->newLine();

        do {
            $commands = trim(mb_strtoupper($this->ask(__('messages.ask.commands'))));
        } while (!strlen($commands));

        $controller = new VehicleController($terrain, $vehicle);
        $path = $controller->executeCommands($commands);

        $finalPosition = collect($path)->last();

        $this->info(__('messages.commands.success', [
            'commands' => $commands,
            'finalPosition' => collect($finalPosition)->implode(','),
        ]));
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
        echo str_pad('', count($terrain->surface[0]) + 2, '-') . PHP_EOL;

        collect($terrain->surface)->each(function ($col, $i) use ($vehicle) {
            echo '|';
            collect($col)->map(function ($obstacle, $j) use ($i, $vehicle) {
                if ($vehicle->latitude === $i && $vehicle->longitude === $j) {
                    echo $vehicle->orientation;
                } elseif (is_bool($obstacle)) {
                    echo $obstacle ? '#' : '.';
                }
            });
            echo '|' . PHP_EOL;
        });

        echo str_pad('', count($terrain->surface[0]) + 2, '-') . PHP_EOL;
        $this->newLine();
    }
}
