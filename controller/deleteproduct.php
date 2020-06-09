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

    $pids = [];
    foreach($input as $pos => $raw)
    {
        $pids[ $pos ] = filter_var($raw, FILTER_SANITIZE_NUMBER_INT);

        //TODO error handling, ideally with tag name in message
        //$errors[$pos] = "$tid: unknown error";
    }

    $db = new DB("SELECT pr_owner, pr_filename FROM products WHERE pid = :pid");
    foreach($pids as $pos => $pid)
    {
        $results = $db->Fetch([ 'pid'=>$pid ]);
        if( $results[0]['pr_owner'] != $_SESSION['username'] )
        {
            $errors[ $pos ] = "#$pid: File not owned.";
            unset( $pids[ $pos ] );
        }
        else
        {
            unlink("ugc/thumb/$pid.jpg");
            unlink("ugc/full/$pid/". $results[0]['pr_filename']);
            //array_map('unlink', glob("ugc/full/*")); // wipe directory
            rmdir("ugc/full/$pid");
        }
    }

    $db = new DB("DELETE FROM products WHERE pid = :pid");
    foreach($pids as $pid)
    {
        $db->Execute([ 'pid'=>$pid ]);
    }

    $db = new DB("DELETE FROM producttags WHERE pid = :pid");
    foreach($pids as $pid)
    {
        $db->Execute([ 'pid'=>$pid ]);
    }

    $db = new DB("DELETE FROM shoppingcart WHERE w_pid = :pid");
    foreach($pids as $pid)
    {
        $db->Execute([ 'pid'=>$pid ]);
    }

    $db = new DB("DELETE FROM userboughtproduct WHERE b_pid = :pid");
    foreach($pids as $pid)
    {
        $db->Execute([ 'pid'=>$pid ]);
    }

    echo json_encode($errors);
}
else
{
    echo "No products selected.";
    return;
}

