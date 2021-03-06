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

$db = new DB("DELETE FROM producttags WHERE tid = {$input['tid']} AND pid = {$input['pid']};");
$db->Execute();

echo "true";
