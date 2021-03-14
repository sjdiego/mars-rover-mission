<?php

namespace Tests\Feature;

use App\Http\Controllers\EnvironmentController;
use App\Models\Terrain;
use App\Models\Vehicle;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * It tests that terrain is created and vehicle is placed
     *
     * @return void
     */
    /** @test */
    public function test_environment_is_created()
    {
        $controller = new EnvironmentController();

        list($terrain, $vehicle) = $controller->prepare();

        $this->assertInstanceOf(Terrain::class, $terrain);
        $this->assertEquals(new Vehicle($vehicle->latitude, $vehicle->longitude, $vehicle->orientation), $vehicle);
    }
}
