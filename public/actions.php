<?php
require_once("../init.php");

/*
|------------------------------------------------
| Routing
|------------------------------------------------
|
| Disclaimer: Not actual routing, but having the files
| require a specific relative path to init sucks
| and feels like a depedency inversion
| matter but this mitigates the problem. -LG
|
*/

$filepath = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
if(!empty( $filepath ) && file_exists("actions/json/$filepath.php"))
{
    include("actions/json/$filepath.php");
}
