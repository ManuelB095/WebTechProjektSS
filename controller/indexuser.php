<?php

$response = [];
$db = new DB("SELECT username FROM users");
$results = $db->Fetch();
foreach($results as $line)
{
    array_push($response, $line['username']);
}
echo json_encode($response);

