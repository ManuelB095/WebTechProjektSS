<?php

// only if logged in
if(empty( $_SESSION['username'] ))
{
    echo "Not logged in.";
    return;
}

// retrieve sanitised inputs
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$input = [
    'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING),
    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
    'title' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
    'firstname' => filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING),
    'lastname' => filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING),
    'address' => filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING),
    'location' => filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING),
    'plz' => filter_input(INPUT_POST, 'plz', FILTER_SANITIZE_STRING),
];
$password_old = filter_input(INPUT_POST, 'password_old', FILTER_SANITIZE_STRING);

// From former "UserControl": make sure there are no unknown inputs?

if(empty( $username ))
{
    echo "No username received.";
    return;
}

$user = new User($username);

if( !$user->exists )
{
    echo "Invalid username.";
    return;
}

if( !password_verify($password_old, $user->password) )
{
    echo "Old password does not match.";
    return;
}

// hash password
if(!empty( $input['password'] ))
{
    $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT); // returns 60 digit of hex chars
}

// insert into model and save changes
foreach( $input as $column => $field )
{
    if(!empty( $field ))
    {
        $user->$column = $field;
    }
}
$user->SaveChanges();

if( $username == $_SESSION['username'] )
{
    $user->LogIn();
}

echo "true";
