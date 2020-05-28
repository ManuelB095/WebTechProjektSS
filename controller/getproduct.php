<?php

$pid = filter_input(INPUT_POST, "pid", FILTER_SANITIZE_STRING);
if(!empty( $pid ))
{
    $product = new Product($pid);
    echo $product->getJSON();
}

//echo '{"id":"1234","filename":"dog-digging-sand-his-head-sand-beach-77290281.jpg","access":"1"}';

