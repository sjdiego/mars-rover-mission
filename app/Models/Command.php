<?php

namespace App\Models;
class Command
{
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
