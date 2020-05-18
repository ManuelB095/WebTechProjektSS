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

$userObj = new UserView();
//$userObj->showUser("asdf");

$userArr = array("username"=>"csdf", "password"=>"pass", "email"=>"emai", "title"=>"Mr", "firstname"=>"Bobo", "lastname"=>"Bibo",
"address"=>"asfjs", "location"=>"vienna", "plz"=>"1234", "is_admin"=>"0", "is_active"=>"0" );

$userObj->createUser($userArr);

//  print "<br><br>";
//  foreach(ini_get_all() as $key=>$value) { echo $key, ' => ', $value['local_value'], '<br>'; }

//  echo empty(ini_get('display_errors'));
