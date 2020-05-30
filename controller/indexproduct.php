<?php

$response = [];
$db = new DB("SELECT pid FROM products");
$results = $db->Fetch();
foreach($results as $line)
{
    array_push($response, $line['pid']);
}
echo json_encode($response);

