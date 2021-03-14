<?php

namespace Tests\Feature;

use App\Models\Terrain;

class MockedTerrain
{
    /**
     * This generates a 9x9 mocked terrain to perform tests
     *
     * Latitude 6 is filled with obstacles
     *
     *  012345678
     * 0.........
     * 1.........
     * 2.........
     * 3.........
     * 4.........
     * 5.........
     * 6XXXXXXXXX
     * 7.........
     * 8.........
     * ===========
     *
     * @return Terrain
     */
    public function get()
    {
        $terrain = new Terrain(8, 8);

        $terrain->surface = [
            0 => [
                0 => false, 1 => false, 2 => false,
                3 => false, 4 => false, 5 => false,
                6 => false, 7 => false, 8 => false,
            ],
            1 => [
                0 => false, 1 => false, 2 => false,
                3 => false, 4 => false, 5 => false,
                6 => false, 7 => false, 8 => false,
            ],
            2 => [
                0 => false, 1 => false, 2 => false,
                3 => false, 4 => false, 5 => false,
                6 => false, 7 => false, 8 => false,
            ],
            3 => [
                0 => false, 1 => false, 2 => false,
                3 => false, 4 => false, 5 => false,
                6 => false, 7 => false, 8 => false,
            ],
            4 => [
                0 => false, 1 => false, 2 => false,
                3 => false, 4 => false, 5 => false,
                6 => false, 7 => false, 8 => false,
            ],
            5 => [
                0 => false, 1 => false, 2 => false,
                3 => false, 4 => false, 5 => false,
                6 => false, 7 => false, 8 => false,
            ],
            6 => [
                0 => true, 1 => true, 2 => true,
                3 => true, 4 => true, 5 => true,
                6 => true, 7 => true, 8 => true,
            ],
            7 => [
                0 => false, 1 => false, 2 => false,
                3 => false, 4 => false, 5 => false,
                6 => false, 7 => false, 8 => false,
            ],
            8 => [
                0 => false, 1 => false, 2 => false,
                3 => false, 4 => false, 5 => false,
                6 => false, 7 => false, 8 => false,
            ],
        ];

        return $terrain;
    }
}
