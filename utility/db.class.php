<?php

class DB
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    public $pdo;

    /*
    |------------------------------------------------
    | Functions
    |------------------------------------------------
    */

    function __construct()
    {
        $connection_string = Config('database','driver');
        $connection_string .= ':host='. Config('database','host');
        $connection_string .= ';dbname='. Config('database','database');
        if( !empty(Config('database','charset')) )
        {
            $connection_string .= ';charset='. Config('database','charset');
        }
        $test = "mysql:host=localhost;dbname=webtech;charset=utf8mb4";
        // $connection_string(currently)equals to  mysql:host='localhost';dbname='webtech';charset='utf8mb4'
        try {
            $this->pdo = new PDO($connection_string, Config('database','username'), Config('database','password'));
        }
        catch(PDOException $e)
        {
            print "ERROR: " . $e->getMessage();
            print $connection_string;
        }
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
}
