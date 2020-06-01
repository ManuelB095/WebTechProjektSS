<?php

// retrieve sanitised inputs
$input = [
    't_name' => filter_input(INPUT_POST, 'tagname', FILTER_SANITIZE_STRING),
];

// From former "UserControl": make sure there are no unknown inputs?

$keys = array_keys($input);
$db = new DB("INSERT INTO tag(". implode(', ', $keys) .") VALUES(:". implode(', :', $keys) .")", true);
$db->Execute($input);

//TODO error handling
// check if any rows have been affected in lastInsertId?

$tid = $db->lastInsertId();
$db->commit();

// Respond with the result of this operation
$tag = new Tag($tid);
echo $tag->getJSON();