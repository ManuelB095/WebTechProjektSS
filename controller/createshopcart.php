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

        $product = new Product( $pid );
        if( $product->pr_owner == $_SESSION['username'] )
        {
            $errors[$pos] = "$pid: Cannot buy own product.";
            continue;
        }
        if( $product->IsBoughtBy($_SESSION['username']) )
        {
            $errors[$pos] = "$pid: Product already bought.";
            continue;
        }

        $db = new DB("INSERT INTO shoppingcart( w_username, w_pid ) VALUES( :w_username, :w_pid )");
        $db->Execute([
            'w_username' => $_SESSION['username'],
            'w_pid' => $pid,
        ]);
    }

    echo json_encode($errors);
}
// allow single-delete by double-checking the input field
elseif(!empty( $input = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT) ))
{
    $product = new Product( $input );
    if( $product->pr_owner == $_SESSION['username'] )
    {
        echo "Cannot buy own product.";
        return;
    }
    if( $product->IsBoughtBy($_SESSION['username']) )
    {
        echo "Product already bought.";
        return;
    }

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
