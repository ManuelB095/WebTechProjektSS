<?php

function Config($file, $property)
{
    assert( !empty( $file )
        && gettype( $file ) == 'string'
        && file_exists( "../config/$file.php" )
    , "Tried to access nonexistant config file $file.php!");

    $data = include("../config/$file.php");

    assert( !empty( $data ) && array_key_exists($property, $data)
    , "Failed to access config property $property in $file.php!");
    
    return $data[ $property ];
}
