<?php

namespace Tests\Feature;

use App\Components\Validations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    /**
     * @return void
     */
    public function testIsEmptyInputData()
    {
        $input = "";
        $validation = new Validations();
        $result = $validation->checkCommand($input);

        $this->assertFalse($result['status']);
    }

    /**
     * @return void
     */
    public function testLinesCommandCounter()
    {
        // 4 Lines
        $input = "5 5\r\n1 2 N\r\nLMLMLMLMM\r\n3 3 E";

        $validation = new Validations();
        $result = $validation->checkCommand($input);

        $this->assertFalse($result['status']);
    }

    /**
     * @return void
     */
    public function testValidAreaSize()
    {
        // Invalid Initial Area
        $input = "ABC 5\r\n1 2 N\r\nLMLMLMLMM\r\n3 3 E\r\nMMRMMRMRRM";

        $validation = new Validations();
        $result = $validation->checkCommand($input);

        $this->assertFalse($result['status']);
    }

    /**
     * @return void
     */
    public function testInitialRoverWrongPosition()
    {
        // "Q" is not an position
        $input = "5 5\r\n1 2 Q\r\nLMLMLMLMM\r\n3 3 E\r\nMMRMMRMRRM";

        $validation = new Validations();
        $result = $validation->checkCommand($input);

        $this->assertFalse($result['status']);
    }

    /**
     * @return void
     */
    public function testInitialRoverPositionIncomplete()
    {
        // 2 data without position (N E S W)
        $input = "5 5\r\n1 2\r\nLMLMLMLMM\r\n3 3 E\r\nMMRMMRMRRM";

        $validation = new Validations();
        $result = $validation->checkCommand($input);

        $this->assertFalse($result['status']);
    }

    /**
     * @return void
     */
    public function testInitialRoverNotNumbersCoordinates()
    {
        // 2 data without position (N E S W)
        $input = "5 5\r\n1 X W\r\nLMLMLMLMM\r\n3 3 E\r\nMMRMMRMRRM";

        $validation = new Validations();
        $result = $validation->checkCommand($input);

        $this->assertFalse($result['status']);
    }

    /**
     * @return void
     */
    public function testRoverMovementNotValid()
    {
        // Command not vallid != (L R M)
        $input = "5 5\r\n1 2 W\r\nLMLXYZLMLMM\r\n3 3 E\r\nMMRMMRMRRM";

        $validation = new Validations();
        $result = $validation->checkCommand($input);

        $this->assertFalse($result['status']);
    }
}
