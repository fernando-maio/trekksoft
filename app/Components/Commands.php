<?php

namespace App\Components;

class Commands
{    
    /**
     * areaSizeX
     *
     * @var string
     */
    private $areaSizeX;    
    /**
     * areaSizeY
     *
     * @var string
     */
    private $areaSizeY;    
    /**
     * positionX
     *
     * @var string
     */
    private $positionX;    
    /**
     * positionY
     *
     * @var string
     */
    private $positionY;    
    /**
     * orientation
     *
     * @var string
     */
    private $orientation;
    
    /**
     * Send is responsible set the mais function, responsible for the actions of the rovers and return the final position of then.
     *
     * @param  string $command
     * @return array Status and message
     */
    public function send($command)
    {
        $finalPosition = '';
        $commandLines = preg_split('/\n|\r\n?/', $command);

        $areaSize = explode(' ', $commandLines[0]);
        $actualPositionOne = explode(' ', $commandLines[1]);
        $actualPositionTwo = explode(' ', $commandLines[3]);

        $this->setAreaSizeX(intVal($areaSize[0]));
        $this->setAreaSizeY(intVal($areaSize[1]));

        $this->setPositionX(intVal($actualPositionOne[0]));
        $this->setPositionY(intVal($actualPositionOne[1]));
        $this->setOrientation($actualPositionOne[2]);
        
        $firstRover = $this->moveRover($commandLines[2]);
        if(!$firstRover['status'])
            return array(
                'status' => false,
                'msg' => $firstRover['msg'],
            );

        $finalPosition .= $this->getPositionX() . ' ' . $this->getPositionY() . ' ' . $this->getOrientation() . '<br>';

        $this->setPositionX(intVal($actualPositionTwo[0]));
        $this->setPositionY(intVal($actualPositionTwo[1]));
        $this->setOrientation($actualPositionTwo[2]);
        
        $secondRover = $this->moveRover($commandLines[4]);
        if(!$secondRover['status'])
            return array(
                'status' => false,
                'msg' => $firstRover['msg'],
            );

        $finalPosition .= $this->getPositionX() . ' ' . $this->getPositionY() . ' ' . $this->getOrientation();

        return array(
            'status' => true,
            'msg' => $finalPosition
        );
    }
    
    /**
     * Move rover recieve the commands from send method, check the previous position and move according is called.
     * In case of some movement exceed the area, it return an error.
     *
     * @param  string $data
     * @return array Status and message
     */
    public function moveRover($data)
    {
        $commands = str_split($data);
        foreach ($commands as $command) {
            if($command == 'R'){
                switch ($this->getOrientation()) {
                    case 'N':
                        $this->setOrientation('E');
                        break;
                    case 'E':
                        $this->setOrientation('S');
                        break;
                    case 'S':
                        $this->setOrientation('W');
                        break;
                    case 'W':
                        $this->setOrientation('N');
                        break;
                }
            }
            if($command == 'L'){
                switch ($this->getOrientation()) {
                    case 'N':
                        $this->setOrientation('W');
                        break;
                    case 'E':
                        $this->setOrientation('N');
                        break;
                    case 'S':
                        $this->setOrientation('E');
                        break;
                    case 'W':
                        $this->setOrientation('S');
                        break;
                }
            }
            if($command == 'M'){
                switch ($this->getOrientation()) {
                    case 'N':
                        $this->setPositionY($this->getPositionY() + 1);
                        break;
                    case 'E':
                        $this->setPositionX($this->getPositionX() + 1);
                        break;
                    case 'S':
                        $this->setPositionY($this->getPositionY() - 1);
                        break;
                    case 'W':
                        $this->setPositionX($this->getPositionX() - 1);
                        break;
                }

                if($this->getPositionX() > $this->getAreaSizeX() || $this->getPositionY() > $this->getAreaSizeY())
                    return array(
                        'status' => false,
                        'msg' => 'Rover can not follow this commands. They exced the area size. Check it and try again.',
                    );
            }            
        }

        return array('status' => true);
    }

    /**
     * Set the value of areaSizeX
     *
     * @return  self
     */ 
    public function setAreaSizeX($areaSizeX)
    {
        $this->areaSizeX = $areaSizeX;

        return $this;
    }

    /**
     * Get the value of areaSizeX
     */ 
    public function getAreaSizeX()
    {
        return $this->areaSizeX;
    }

    /**
     * Set the value of areaSizeY
     *
     * @return  self
     */ 
    public function setAreaSizeY($areaSizeY)
    {
        $this->areaSizeY = $areaSizeY;

        return $this;
    }

    /**
     * Get the value of areaSizeY
     */ 
    public function getAreaSizeY()
    {
        return $this->areaSizeY;
    }

    /**
     * Set the value of orientation
     *
     * @return  self
     */ 
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get the value of orientation
     */ 
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Get the value of positionX
     */ 
    public function getPositionX()
    {
        return $this->positionX;
    }

    /**
     * Set the value of positionX
     *
     * @return  self
     */ 
    public function setPositionX($positionX)
    {
        $this->positionX = $positionX;

        return $this;
    }

    /**
     * Get the value of positionY
     */ 
    public function getPositionY()
    {
        return $this->positionY;
    }

    /**
     * Set the value of positionY
     *
     * @return  self
     */ 
    public function setPositionY($positionY)
    {
        $this->positionY = $positionY;

        return $this;
    }
}
