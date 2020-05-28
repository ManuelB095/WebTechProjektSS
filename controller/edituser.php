<?php

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

// From former "UserControl": make sure there are no unknown inputs?

if(empty( $input['username'] ))
{
    return "No username received.";
}

//password_verify($hashedPW, $PWfromDB); // Verify that typed password/Username Combination is the same as the ( hashed one in the database )

// insert into model and save changes
$user = new User($username);
foreach( $input as $column => $field )
{
    $user->$column = $field;
}
$user->SaveChanges();

//TODO error handling
