<?php

// retrieve sanitised inputs
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if(empty( $input['username'] ) || empty( $input['password'] ))
{
    return "No username or password received.";
}


$user = new User($username);
if( $user->exists && password_verify( $password, $user->password ) )
{
    if( !$user->is_active )
    {
        return "This account has been deactivated.";
    }

    if(password_needs_rehash( $user->password, PASSWORD_DEFAULT ))
    {
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->SaveChanges();
    }

    // populate $_SESSION as needed if successfully logged in
    foreach( User::$publicFields as $field )
    {
        $_SESSION[$field] = $user->$field;
    }

    echo "true";
}
else
{
    return "Password or username incorrect";
}

