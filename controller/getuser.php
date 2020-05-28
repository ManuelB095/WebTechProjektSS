<?php

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
if(!empty( $username )) //&& !empty($user = User()->getUser($username)) )
{
    $user = new User($username);
    echo $user->getJSON();
}
