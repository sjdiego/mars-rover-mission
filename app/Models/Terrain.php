<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    use HasFactory;

    public const WIDTH = 45;
    public const HEIGHT = 15;
    public const OBSTACLE_PROBABLITY = 0.02;

    /**
     * It returns a terrain with randomly placed obstacles
     *
     * @return array
     */
    public function generate(): array
    {
        $terrain = [];

        for ($i = 1; $i <= self::HEIGHT; $i++) {
            for ($j = 1; $j <= self::WIDTH; $j++) {
                $terrain[$i][$j] = (random_int(0, 100) / 100 <= self::OBSTACLE_PROBABLITY) ? 1 : 0;
            }
        }

        return $terrain;
    }

    public function draw(array $terrain): void
    {
        echo str_pad('', count($terrain[1]) + 2, '-') . PHP_EOL;

        for ($i = 1; $i <= count($terrain); $i++) {
            for ($j = 1; $j <= count($terrain[$i]); $j++) {
                if ($j === 1) {
                    echo "|";
                }

                echo $terrain[$i][$j] === 0 ? ' ' : 'X';

                if ($j === count($terrain[$i])) {
                    echo "|" . PHP_EOL;
                }
            }
        }

        echo str_pad('', count($terrain[1]) + 2, '-') . PHP_EOL;
    }
}
