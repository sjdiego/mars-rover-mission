<?php

namespace App\Console\Commands;

use App\Models\Terrain;
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
        $this->prepareEnvironment();
    }

    protected function prepareEnvironment() {
        $terrain = new Terrain();

        $generatedTerrain = $terrain->generate();

        $terrain->draw($generatedTerrain);
    }
}
