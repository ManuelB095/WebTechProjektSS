<?php

// only if logged in
if(empty( $_SESSION['username'] ))
{
    echo "Not logged in.";
    return;
}

// retrieve sanitised inputs
$input = [
    't_name' => filter_input(INPUT_POST, 't_name', FILTER_SANITIZE_STRING),
];

// From former "UserControl": make sure there are no unknown inputs?

$keys = array_keys($input);
$db = new DB("INSERT INTO tags(". implode(', ', $keys) .") VALUES(:". implode(', :', $keys) .")", true);
$db->Execute($input);

$tid = $db->lastInsertId();
if(empty( $tid ))
{
    echo "Tag not saved.";
    return;
}

$db->commit();

// Respond with the result of this operation
$tag = new Tag($tid);
echo $tag->getJSON();
