<?php

namespace Tests\Unit;

use App\Models\Command;
use App\Models\Vehicle;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function test_create_vehicle()
    {
        $vehicle = new Vehicle(15, 15, 'N');

        $this->assertIsObject($vehicle);
        $this->assertObjectHasAttribute('latitude', $vehicle);
        $this->assertObjectHasAttribute('longitude', $vehicle);
        $this->assertObjectHasAttribute('orientation', $vehicle);
    }

    public function test_create_vehicle_with_wrong_orientation()
    {
        $this->expectExceptionMessage('Orientation X is not available.');

        new Vehicle(1, 1, 'X');
    }

    public function test_get_vehicle_forward_movement()
    {
        $vehicle = new Vehicle(10, 10, 'E');

        $movement = $vehicle->getCoordsFromCommand(new Command('F'));

        $this->assertEquals(10, $movement['latitude']);
        $this->assertEquals(11, $movement['longitude']);
    }

    public function test_get_vehicle_right_movement()
    {
        $vehicle = new Vehicle(10, 10, 'N');

        $movement = $vehicle->getCoordsFromCommand(new Command('R'));

        $this->assertEquals(10, $movement['latitude']);
        $this->assertEquals(11, $movement['longitude']);
    }

    public function test_get_vehicle_left_movement()
    {
        $vehicle = new Vehicle(10, 10, 'W');

        $movement = $vehicle->getCoordsFromCommand(new Command('L'));

        $this->assertEquals(11, $movement['latitude']);
        $this->assertEquals(10, $movement['longitude']);
    }
}
