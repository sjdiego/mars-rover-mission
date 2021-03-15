<?php

namespace App\Models;

/**
 * Class that manages the creation of valid Commands
 */
class Command
{
    const AVAILABLE_COMMANDS = ['F', 'R', 'L'];

    public function __construct(public string $command)
    {
        if (!in_array(mb_strtoupper($command), self::AVAILABLE_COMMANDS)) {
            throw new \Exception("Command ${command} is not available.");
        }
    }
}
