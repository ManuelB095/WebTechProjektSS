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

$userObj = new UserControl();
//$userObj->showUser("asdf");

// DEBUG: ALL 3 errors ( Necessary missing, non whiteListed argument, too many arguments)
$userArr1 = array("extra"=>"extra", "double"=>"double", "testi"=>"test", "password"=>"pass", "email"=>"emai", "title"=>"Mr", "firstname"=>"Bobo", "lastname"=>"Bibo",
"address"=>"asfjs", "plz"=>"1234", "is_admin"=>"0", "is_active"=>"0" );
// This one is correct, except with missing location ( gets set as NULL in class)
$userArr2 = array("username"=>"csdf", "password"=>"pass", "email"=>"emai", "title"=>"Mr", "firstname"=>"Bobo", "lastname"=>"Bibo",
"address"=>"asfjs", "plz"=>"1234", "is_admin"=>"0", "is_active"=>"0" );
// This one is 100% correct
$userArr3 = array("username"=>"asdf", "password"=>"halloo","email"=>"emma", "email"=>"emai", "title"=>"Mr", "firstname"=>"Bobo", "lastname"=>"Bibo",
"address"=>"asfjs", "location" => "vienna", "is_admin"=>"0", "is_active"=>"0" );

// Testing Grounds

// $userObj->createUser($userArr3);
// $userObj->editUser($userArr3);
?>
<nav>
        <a href="shop">Galerie</a>
        <a href="help">Hilfe</a>
        <a href="rss">RSS Feed</a>
        <a href="admin">Administration</a>
        <?php
        if( TRUE ) {
        ?>
            <a><?php //TODO insert username, clickable for profile settings? ?></a>
            <a>Logout</a>
        <?php
        } else { //nicht angemeldet
        ?>
            <a>Registrieren</a>
            <a>Login</a>
        <?php } ?>
    </nav>

<?php

//  print "<br><br>";
//  foreach(ini_get_all() as $key=>$value) { echo $key, ' => ', $value['local_value'], '<br>'; }

//  echo empty(ini_get('display_errors')); ?>
