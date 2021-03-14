<?php

namespace Tests\Unit;

use App\Models\Terrain;
use PHPUnit\Framework\TestCase;

class TerrainTest extends TestCase
{
    public function test_create_basic_terrain()
    {
        $terrain = new Terrain(35, 55);

        $this->assertIsObject($terrain);
        $this->assertIsArray($terrain->surface);
        $this->assertCount(55, $terrain->surface);
        $this->assertCount(35, collect($terrain->surface)->first());
    }

    public function test_create_bigger_terrain()
    {
        $terrain = new Terrain(200, 500);

        $this->assertIsObject($terrain);
        $this->assertIsArray($terrain->surface);
        $this->assertCount(500, $terrain->surface);
        $this->assertCount(200, collect($terrain->surface)->first());
    }

    public function test_get_random_location()
    {
        $terrain = new Terrain(15, 15);

        $randomLocation = $terrain->getRandomLocation();

        $this->assertArrayHasKey('latitude', $randomLocation);
        $this->assertArrayHasKey('longitude', $randomLocation);

        $this->assertIsInt($randomLocation['latitude']);
        $this->assertIsInt($randomLocation['longitude']);

        $this->assertArrayHasKey($randomLocation['latitude'], $terrain->surface);
        $this->assertArrayHasKey($randomLocation['longitude'], $terrain->surface[$randomLocation['latitude']]);
    }
}
