<?php

$pid = filter_input(INPUT_POST, "pid", FILTER_SANITIZE_STRING);
if(!empty( $pid ))
{
    $product = new Product($pid);
    echo $product->getJSON();
}

