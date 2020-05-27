<?php
require_once("../init.php");

/*
|------------------------------------------------
| Routing
|------------------------------------------------
|
| Disclaimer: Not proper routing, but requiring
| a specific relative path to init sucks
| and feels like a deep depedency inversion
| problem but this mitigates it and was quick. -LG
|
*/

$filepath = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
if(!empty( $filepath )) 
{
    if( file_exists("../controller/$filepath.php") )
    {
        include("../controller/$filepath.php");
    }
    else if( file_exists("../json/$filepath.php") )
    {
        include("../json/$filepath.php");
    }
}
