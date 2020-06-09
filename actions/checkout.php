<?php

// only if logged in
if(empty( $_SESSION['username'] ))
{
    echo "Not logged in.";
    return;
}

$errors = [];
//TODO error handling, ideally with product name in message

// first, get the list of desired items
$db = new DB("SELECT w_pid FROM shoppingcart WHERE w_username = :w_username");
$results = $db->Fetch([
    'w_username' => $_SESSION['username'],
]);

// now mark those as bought
$db = new DB("INSERT INTO userboughtproduct(b_pid, b_username) VALUES(:b_pid, :b_username)");
foreach($results as $line)
{
    $db->Execute([
        'b_pid' => $line['w_pid'],
        'b_username' => $_SESSION['username'],
    ]);
}

// lasty clear the list (TODO only for successfully bought items?)
$db = new DB("DELETE FROM shoppingcart WHERE w_username = :w_username");
$db->Execute([
    'w_username' => $_SESSION['username'],
]);


echo json_encode($errors);

