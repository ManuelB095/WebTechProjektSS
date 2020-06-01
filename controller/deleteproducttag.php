<?php

// retrieve sanitised inputs
$input = [
    'tid' => filter_input(INPUT_POST, 'tid', FILTER_SANITIZE_NUMBER_INT),
    'pid' => filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT),
];

// From former "UserControl": make sure there are no unknown inputs?

$db = new DB("DELETE FROM producttags WHERE tid = {$input['tid']} AND pid = {$input['pid']};");
$db->Execute();

//TODO error handling

echo "true";
