<?php

namespace Tests\Unit;

use App\Models\Command;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    /** @test */
    public function test_using_real_command()
    {
        $cmd = new Command('F');

        $this->assertIsObject($cmd);
        $this->assertObjectHasAttribute('command', $cmd);
    }

    public function test_using_not_existent_command()
    {
        $this->expectExceptionMessage('Command A is not available');

        new Command('A');
    }

    /** @test */
    public function test_using_empty_command()
    {
        $this->expectExceptionMessage('Command  is not available');

        new Command(false);
    }

    /** @test */
    public function test_using_multiple_commands()
    {
        $this->expectExceptionMessage('Command FRLFR is not available');

        new Command('FRLFR');
    }
}
