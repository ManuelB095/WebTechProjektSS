<?php

session_start();

require_once 'utility/config.php';
require_once 'utility/storage.php';

spl_autoload_register(function ($class) {
    $class = strtolower($class);
    if( file_exists('utility/' . $class . '.class.php') )
    {
        include_once 'utility/' . $class . '.class.php';
    }
    else if( file_exists('model/' . $class . '.class.php') )
    {
        include_once 'model/' . $class . '.class.php';
    }
});


$user = new User('asdf');
echo $user->vorname;
$user->vorname = 'Emil';
echo $user->vorname;
$user->username = 'username';

foreach(ini_get_all() as $key=>$value) { echo $key, ' => ', $value['local_value'], '<br>'; }

echo empty(ini_get('display_errors'));
