<?php

class DB
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    private $pdo;

    /*
    |------------------------------------------------
    | Functions
    |------------------------------------------------
    */

    function __construct()
    {
        $connection_string = Config('database')->driver;
        $connection_string .= ':host='. Config('database')->host;
        $connection_string .= ';dbname='. Config('database')->database;
        if( !empty(Config('database')->charset) )
        {
            $connection_string .= ';charset='. Config('database')->charset;
        }
        $this->pdo = PDO($connection_string, Config('database')->username, Config('database')->password);
    }
}
