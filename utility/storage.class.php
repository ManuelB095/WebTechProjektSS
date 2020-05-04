<?php

class Storage
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    private static $default;
    private static $storages;

    private $storage

    /*
    |------------------------------------------------
    | Use Functions
    |------------------------------------------------
    */

    function __construct($desired_storage)
    {
        if( !empty( $desired_storage )
            && gettype( $desired_storage ) == 'string'
            && !empty( self::$storages[ $desired_storage ] )
        ) {
            $this->$storage = Config('storage')->paths[ $desired_storage ];
        }
        else
        {
            $this->$storage = Config('storage')->paths[ Config('storage')->default ];
        }
    }

    public function __toString()
    {
        return $this->$storage['root'];
    }

}
