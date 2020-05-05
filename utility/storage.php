<?php

function Storage($desired_storage)
{
    $allpaths = Config('storage','paths');
    if( !empty($allpaths) )
    {
        if( !empty( $desired_storage )
            && gettype( $desired_storage ) == 'string'
            && !empty( $allpaths[ $desired_storage ] )
        ) {
            $storage = $allpaths[ $desired_storage ];
            return $storage['root'];
        }
        else
        {
            $storage = $allpaths[ Config('storage','default') ];
            return $storage['root'];
        }
    }
    /*if( empty(ini_get('display_errors')) )
    {
        //in deployed environment, wrong directory is probably better than crashing
        return '';
    }*/
}
