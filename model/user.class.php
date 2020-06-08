<?php

class User extends Model
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    const publicFields = ["username", "email", "title", "firstname", "lastname", "address", "location", "plz", "is_admin", "is_active"];

    /*
    |------------------------------------------------
    | Magic Methods
    |------------------------------------------------
    */

    function __construct($username)
    {
        //ctor
        $this->AutoFillByKeyValue('users','username',$username);
    }

    /*
    |------------------------------------------------
    | Use Functions
    |------------------------------------------------
    */

    function LogIn()
    {
        // populate $_SESSION as needed if not logged in yet
        if( $this->exists )
        {
            foreach( self::publicFields as $field )
            {
                $_SESSION[$field] = $this->fields[ $field ];
            }
        }
    }

}
