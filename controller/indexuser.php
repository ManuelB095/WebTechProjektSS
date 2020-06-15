<?php

if(empty( $_SESSION['is_admin'] ))
{
    echo "This is kind of sensitive information, you know? Only for Admins.";
    return;
}

$response = [];
$db = new DB("SELECT username FROM users");
$results = $db->Fetch();
foreach($results as $line)
{
    array_push($response, $line['username']);
}
echo json_encode($response);

