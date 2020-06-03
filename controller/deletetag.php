<?php

// retrieve sanitised inputs
$inputjson = filter_input(INPUT_POST, 'tid', FILTER_UNSAFE_RAW);

$input = json_decode($inputjson);

// batch-delete in a single request
if( !empty($input) && gettype($input) == 'array' )
{
    $errors = [];

    foreach($input as $pos => $raw)
    {
        $tid = filter_var($raw, FILTER_SANITIZE_NUMBER_INT);

        // detag affected products (TODO can the DB do this for us automatically?)
        $db = new DB("DELETE FROM producttags WHERE tid = $tid;");
        $db->Execute();

        $db = new DB("DELETE FROM tags WHERE tid = $tid;");
        $db->Execute();

        //TODO error handling, ideally with tag name in message
        //$errors[$pos] = "$tid: unknown error";
    }

    echo json_encode($errors);
}
else
{
    echo "No tags selected.";
    return;
}

