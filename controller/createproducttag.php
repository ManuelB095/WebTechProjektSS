<?php

// only if logged in
if(empty( $_SESSION['username'] ))
{
    echo "Not logged in.";
    return;
}

// retrieve sanitised inputs
$input = [
    'tid' => filter_input(INPUT_POST, 'tid', FILTER_SANITIZE_NUMBER_INT),
    'pid' => filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT),
];

// From former "UserControl": make sure there are no unknown inputs?

$product = new Product( $input['pid'] );
if( $product->pr_owner != $_SESSION['username'] && !$product->IsBoughtBy($_SESSION['username']) )
{
    echo "Cannot tag foreign products.";
    return;
}

$db = new DB('SELECT COUNT(*) FROM producttags WHERE pid = :pid AND tid = :tid');
$results = $db->Fetch([
    'pid' => $input['pid'],
    'tid' => $input['tid'],
]);
if(!empty( $results[0]['COUNT(*)'] ))
{
    echo "Already tagged.";
    return;
}


$keys = array_keys($input);
$db = new DB("INSERT INTO producttags(". implode(', ', $keys) .") VALUES(:". implode(', :', $keys) .")");
$db->Execute($input);

echo "true";
