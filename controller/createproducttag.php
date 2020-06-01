<?php

// retrieve sanitised inputs
$input = [
    'tid' => filter_input(INPUT_POST, 'tid', FILTER_SANITIZE_NUMBER_INT),
    'pid' => filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT),
];

// From former "UserControl": make sure there are no unknown inputs?

$keys = array_keys($input);
$db = new DB("INSERT INTO producttags(". implode(', ', $keys) .") VALUES(:". implode(', :', $keys) .")");
$db->Execute($input);

//TODO error handling

