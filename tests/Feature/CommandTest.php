<?php

namespace Tests\Feature;

use App\Components\Commands;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandTest extends TestCase
{
    /**
     * @return void
     */
    public function testMoveRoverOutsideDefinedArea()
    {
        // Trying to move the rover outside delimited Area (5 5)
        $input = "5 5\r\n1 2 N\r\nLMLMLMLMMMMMMM\r\n3 3 E\r\nMMRMMRMRRM";

        $command = new Commands();
        $result = $command->send($input);

        $this->assertFalse($result['status']);
    }

    /**
     * @return void
     */
    public function testreturnFinalValidPosition()
    {
        // Returning a valid final position (1 3 N, 5 1 N)
        $input = "5 5\r\n1 2 N\r\nLMLMLMLMM\r\n3 3 E\r\nMMRMMRMRRM";

        $command = new Commands();
        $result = $command->send($input);

        $this->assertTrue($result['status']);
    }
}
