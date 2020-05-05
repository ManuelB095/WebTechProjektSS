<?php

function Config($file, $property)
{
    if( !empty( $file ) && gettype( $file ) == 'string' )
    {
        $data = include("config/$file.php");
        if( !empty( $data ) && array_key_exists($property, $data))
        {
            return $data[ $property ];
        }
    }
}
