<?php

// retrieve sanitised inputs
$input = [
    'username' => filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING),
    'password' => filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING),
    'email' => filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL),
    'title' => filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING),
    'firstname' => filter_input(INPUT_GET, 'firstname', FILTER_SANITIZE_STRING),
    'lastname' => filter_input(INPUT_GET, 'lastname', FILTER_SANITIZE_STRING),
    'address' => filter_input(INPUT_GET, 'address', FILTER_SANITIZE_STRING),
    'location' => filter_input(INPUT_GET, 'location', FILTER_SANITIZE_STRING),
    'plz' => filter_input(INPUT_GET, 'plz', FILTER_SANITIZE_STRING),
];

// From former "UserControl": make sure there are no unknown inputs?

if(empty( $input['username'] ) || empty( $input['password'] ))
{
    return "No username or password received.";
}

// hash password
$input['password'] = password_hash($input['password'], PASSWORD_DEFAULT); // returns 60 digit of hex chars

$keys = array_keys($input);
$db = new DB("INSERT INTO users(". implode(', ', $keys) .") VALUES(:". implode(':, ', $keys) .")");
$db->Fetch($input);

//TODO error handling
