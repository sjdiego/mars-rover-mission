<?php

namespace Tests\Feature;

use App\Http\Controllers\VehicleController;
use App\Models\{Terrain, Vehicle};
use Tests\TestCase;

class VehicleTest extends TestCase
{
    public function test_controller_is_created()
    {
        $terrain = new Terrain(15, 15);
        $position = $terrain->getRandomLocation();
        $vehicle = new Vehicle(
            $position['latitude'],
            $position['longitude'],
            Vehicle::ORIENTATIONS[array_rand(Vehicle::ORIENTATIONS, 1)]
        );
        $controller = new VehicleController($terrain, $vehicle);

        $this->assertInstanceOf(VehicleController::class, $controller);
    }

    public function test_single_command()
    {
        $terrain = (new MockedTerrain)->get();
        $vehicle = new Vehicle(2, 3, 'N');
        $controller = new VehicleController($terrain, $vehicle);

        $path = collect($controller->executeCommands('F'))->first();

        $this->assertEquals(1, $path['latitude']);
        $this->assertEquals(3, $path['longitude']);
        $this->assertEquals('N', $path['orientation']);
    }

    public function test_multiple_commands_without_collision()
    {
        $terrain = (new MockedTerrain)->get();
        $vehicle = new Vehicle(2, 3, 'N');
        $controller = new VehicleController($terrain, $vehicle);

        $path = collect($controller->executeCommands('FRFF'))->last();

        $this->assertEquals(1, $path['latitude']);
        $this->assertEquals(6, $path['longitude']);
        $this->assertEquals('E', $path['orientation']);
    }

    public function test_multiple_commands_with_collision()
    {
        $terrain = (new MockedTerrain)->get();
        $vehicle = new Vehicle(4, 4, 'E');
        $controller = new VehicleController($terrain, $vehicle);

        $this->expectExceptionMessage(__('messages.colission.detected', [
            'obstacle' => '6,6,S',
            'safePosition' => '5,6'
        ]));

        $controller->executeCommands('FFRFFF');
    }

    public function test_multiple_commands_leaving_terrain()
    {
        $terrain = (new MockedTerrain)->get();
        $vehicle = new Vehicle(4, 4, 'W');
        $controller = new VehicleController($terrain, $vehicle);

        $this->expectExceptionMessage(__('messages.colission.detected', [
            'obstacle' => '4,-1,W',
            'safePosition' => '4,0'
        ]));

        $controller->executeCommands('FFFFF');
    }
}
