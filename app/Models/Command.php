<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    const AVAILABLE_COMMANDS = [
        'F' => 'Forward',
        'R' => 'Right',
        'L' => 'Left',
    ];

    public function __construct(public string $command)
    {
        if (!in_array($command, self::AVAILABLE_COMMANDS)) {
            throw new \Exception('Command \'${command}\' is not available.');
        }
    }
}
