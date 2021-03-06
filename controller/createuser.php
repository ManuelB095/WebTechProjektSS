<?php

// retrieve sanitised inputs
$input = [
    'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING),
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

if(empty( $input['username'] ) || empty( $input['password'] ))
{
    echo "No username or password received.";
    return;
}

// hash password
$input['password'] = password_hash($input['password'], PASSWORD_DEFAULT); // returns 60 digit of hex chars

$keys = array_keys($input);
$db = new DB("INSERT INTO users(". implode(', ', $keys) .") VALUES(:". implode(', :', $keys) .")");

if( $db->Execute($input) && empty( $_SESSION['username'] ))
{
    $user = new User( $input['username'] );
    $user->LogIn();
}

echo "true";
