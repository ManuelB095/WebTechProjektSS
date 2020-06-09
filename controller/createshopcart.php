<?php

// only if logged in
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
    $errors = [];

    foreach($input as $pos => $raw)
    {
        $pid = filter_var($raw, FILTER_SANITIZE_NUMBER_INT);

        $db = new DB("INSERT INTO shoppingcart( w_username, w_pid ) VALUES( :w_username, :w_pid )");
        $db->Execute([
            'w_username' => $_SESSION['username'],
            'w_pid' => $pid,
        ]);

        //TODO error handling, ideally with product name in message
        //$errors[$pos] = "$pid: unknown error";
    }

    echo json_encode($errors);
}
// allow single-delete by double-checking the input field
elseif(!empty( $input = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT) ))
{
    $db = new DB("INSERT INTO shoppingcart( w_username, w_pid ) VALUES( :w_username, :w_pid )");
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
