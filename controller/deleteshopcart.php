<?php

// only if logged in (how'd you get here not being logged in anyways?)
if(empty( $_SESSION['username'] ))
{
    echo "Not logged in.";
    return;
}

// retrieve sanitised inputs
$inputjson = filter_input(INPUT_POST, 'pid', FILTER_UNSAFE_RAW);

$input = json_decode($inputjson);

// batch-delete in a single request
if( !empty($input) && gettype($input) == 'array' )
{
    foreach($input as $pos => $raw)
    {
        $pid = filter_var($raw, FILTER_SANITIZE_NUMBER_INT);

        $db = new DB("DELETE FROM shoppingcart WHERE w_username = :w_username AND w_pid = :w_pid");
        $db->Execute([
            'w_username' => $_SESSION['username'],
            'w_pid' => $pid,
        ]);
    }
}
// allow single-delete by double-checking the input field
elseif(!empty( $input = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT) ))
{
    $db = new DB("DELETE FROM shoppingcart WHERE w_username = :w_username AND w_pid = :w_pid");
    $db->Execute([
        'w_username' => $_SESSION['username'],
        'w_pid' => $input,
    ]);

    echo "true";
}
else
{
    echo "No products selected.";
    return;
}
