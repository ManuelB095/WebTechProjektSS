<?php

$response = [];
$db = new DB("SELECT tid FROM tag");
$results = $db->Fetch();
foreach($results as $line)
{
    array_push($response, $line['tid']);
}
echo json_encode($response);

