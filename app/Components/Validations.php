<?php

namespace App\Components;

class Validations
{
    /**
     * Validate if the commands sent are valid.
     * 
     * @param string $data
     * @return array Status and message
     */
    public static function checkCommand($data)
    {
        $lineCheck = array(
            'areaSize',
            'initialCoordinates',
            'actionCommands',
            'initialCoordinates',
            'actionCommands'
        );

        if(!self::isEmpty($data))
            return array(
                'status' => false,
                'msg' => 'Command can not be empty',
            );
        
        $commandLines = preg_split('/\n|\r\n?/', $data);

        if(!self::countLines($commandLines, 5))
            return array(
                'status' => false,
                'msg' => 'You need to send 5 commands',
            );

        foreach ($commandLines as $key => $line) {
            $function = $lineCheck[$key];            
            $line = self::$function($line);
            
            if(!$line['status'])
                return array(
                    'status' => false,
                    'msg' => $line['msg'],
                );
        }
        
        return array(
            'status' => true
        );
    }
    
    /**
     * Check if the request is empty 
     *
     * @param  string $data
     * @return boolean
     */
    private static function isEmpty($data)
    {
        return empty($data) ? false : true;
    }
    
    /**
     * Count the number of lines in array
     *
     * @param  array $data
     * @param  int $lines
     * @return boolean
     */
    private static function countLines($data, $lines)
    {
        return count($data) != $lines ? false : true;
    }
    
    /**
     * Validate if the area have 2 coordinates, and if they are correct.
     *
     * @param  mixed $data
     * @return array Status and message
     */
    private static function areaSize($data)
    {
        $lines = explode(' ', $data);
        
        if(!self::countLines($lines, 2))
            return array(
                'status' => false,
                'msg' => 'You need to send 2 coordinates of the area size',
            );

        foreach ($lines as $line) {
            if(!is_numeric($line))
                return array(
                    'status' => false,
                    'msg' => 'The area size need to be numbers',
                );
        }
            
        return array('status' => true);
    }
    
    /**
     * Validate if the initial coordinate of the rover are correct. If not, it returns an error.
     *
     * @param  string $data
     * @return array Status and message
     */
    private static function initialCoordinates($data)
    {
        $lines = explode(' ', $data);
        
        if(!self::countLines($lines, 3))
            return array(
                'status' => false,
                'msg' => 'You need to send 2 initial coordinates of the area',
            );

        if(!is_numeric($lines[0]) || !is_numeric($lines[1]))
            return array(
                'status' => false,
                'msg' => 'The initial coordinates of the area need to be numbers',
            );

        if(!in_array($lines[2], array('N', 'E', 'S', 'W')))
            return array(
                'status' => false,
                'msg' => 'The action commands need to be N, E, S or W',
            );

        return array('status' => true);
    }
    
    /**
     * Validate the movement commands of the rovers. If it not be L, R or M, will return an error. 
     *
     * @param  string $data
     * @return @return array Status and message
     */
    private static function actionCommands($data)
    {
        $commands = str_split($data);

        foreach ($commands as $command) {
            if(!in_array($command, array('L', 'R', 'M')))
                return array(
                    'status' => false,
                    'msg' => 'The action commands need to be L, R or M',
                );
        }

        return array('status' => true);
    }
}