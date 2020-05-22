<?php

/*
$imageid = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
if(!empty( $imageid )) //&& !empty($user = User()->getUser($username)) )
{
    $image = new Image();
    echo $image->getJSON($imageid);
}
*/

echo '{"id":"1234","filename":"johanna-pferd.jpg","access":"1"}';

