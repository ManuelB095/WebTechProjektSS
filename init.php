<?php

/*
|------------------------------------------------
| Helper Functions
|------------------------------------------------
*/

require_once '../utility/config.php';
require_once '../utility/storage.php';

//autoloader for classes

spl_autoload_register(function ($class) {
    //filenames are always lowercase in this server
    $class = strtolower($class);
    if( file_exists('../utility/' . $class . '.class.php') )
    {
        include_once '../utility/' . $class . '.class.php';
    }
    else if( file_exists('../model/' . $class . '.class.php') )
    {
        include_once '../model/' . $class . '.class.php';
    }
});

include_once '../utility/User.class.php';
/*
|------------------------------------------------
| Session
|------------------------------------------------
*/

session_start();

