<?php

$tid = filter_input(INPUT_POST, "tid", FILTER_SANITIZE_STRING);
if(!empty( $tid ))
{
    $tag = new Tag($tid);
    echo $tag->getJSON();
}

