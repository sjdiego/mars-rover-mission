<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConsoleRoverTest extends TestCase
{
    public function test_question()
    {
        $this->artisan('rover')
            ->expectsOutput(__('messages.terrain.generated'))
            ->expectsQuestion(__('messages.ask.commands'), 'F');
    }
}
