<?php

class User
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    private $username;
    private $password;
    private $email;

    private $isadmin;
    private $isactive;

    private $anrede;
    private $vorname;
    private $nachname;
    private $adresse;
    private $ort;
    private $plz;

    /*
    |------------------------------------------------
    | Magic Methods
    |------------------------------------------------
    */

    function __construct()
    {
        //ctor
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
