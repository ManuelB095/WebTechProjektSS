<?php

class User extends Model
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */


    /*
    |------------------------------------------------
    | Magic Methods
    |------------------------------------------------
    */

    function __construct($username)
    {
        //ctor
        $this->AutoFillByKeyValue('webuser','username',$username);
    }

    function __destruct()
    {
        //dtor
    }

    /*
    |------------------------------------------------
    | Use Functions
    |------------------------------------------------
    */

    public function myFunction()
    {
        //dtor
    }
}
