<?php

class User extends Model
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    public static const $publicFields = ["username", "email", "title", "firstname", "lastname", "address", "location", "plz", "is_admin", "is_active"];

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

}
