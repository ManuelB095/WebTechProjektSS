<?php

class User extends Model
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    private $tblUsers;

    /*
    |------------------------------------------------
    | Magic Methods
    |------------------------------------------------
    */

    function __construct($username)
    {
        //ctor
        $this->AutoFillByKeyValue('exampletable','ex_username',$username);
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
    protected function getUser($username)
    {
        // Basicalle return $this->fields;
        // Not needed since user Data is automatically submitted in the constructor
        // QUESTION: Password as additional condition to access user data ?
    }

    public function setUser($firstName, $lastName, $password)
    {
        $this->ex_firstname = filter_var($firstName, FILTER_SANITIZE_STRING);
        print 'EX-USERNAME: ' . $this->ex_firstname;
        $this->ex_lastname = filter_var($lastName, FILTER_SANITIZE_STRING);
        print $this->ex_lastname;
        $this->ex_password = $password;//$this->getHashedPassword($password, $this->ex_username);
        print $this->ex_password;
        $this->PushChanges();
    }

    public function createUser()
    {
        $vals = ["bsdf","Benjamin", "Blümchen", "töröö"];
        $this->pushAsNewEntry($vals);
    }

    private function getHashedPassword($pwd='',$user=''){
        return password_hash($pwd.$user, PASSWORD_DEFAULT); // returns 60 digit of hex chars
    }

    private function isPasswordCorrect($LogPW,$LogUSR,$DataBasePW)
    {
        return password_verify($LogPW.$LogUSR, $DataBasePW); // Verify that typed password/Username Combination is the same as the ( hashed one in the database )
    }
}
