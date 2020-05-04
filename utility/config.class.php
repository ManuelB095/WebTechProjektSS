<?php

class Config
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    private $data

    /*
    |------------------------------------------------
    | Use Functions
    |------------------------------------------------
    */

    function __construct($file)
    {
        if( !empty( $file ) && gettype( $file ) == 'string' )
        {
            $this->$data = include("config/$file.php");
        }
    }

    public function __get($name)
    {
        if( !empty( $this->data ) && array_key_exists($name, $this->data))
        {
            return $this->data[$name];
        }
    }

}
