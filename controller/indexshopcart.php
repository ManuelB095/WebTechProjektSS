<?php

$response = [];

// only makes sense if logged in
if(!empty( $_SESSION['username'] ))
{
    $db = new DB("SELECT w_pid FROM shoppingcart WHERE w_username = :w_username");
    $results = $db->Fetch([
        'w_username'=>$_SESSION['username']
    ]);

    foreach($results as $line)
    {
        array_push($response, $line['w_pid']);
    }
}

echo json_encode($response);

