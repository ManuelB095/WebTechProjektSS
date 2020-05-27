<?php

class User extends Model
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    protected $exists = false;
    //TODO The "publicFields" should really not be an object variable. -LG
    //TODO Maybe blacklist instead of whitelist? -LG
    //TODO Maybe omit more fields depending on login/ownership/admin status? -LG
    protected $publicFields = ["username", "email", "title", "firstname", "lastname", "address", "location", "plz", "is_admin", "is_active"];

    /*
    |------------------------------------------------
    | Magic Methods
    |------------------------------------------------
    */

    function __construct($username)
    {
        //ctor
        $this->exists = $this->AutoFillByKeyValue('users','username',$username);
    }

    /*
    |------------------------------------------------
    | Use Functions
    |------------------------------------------------
    */

    public function getJSON()
    {
        if( !$this->exists ) return;

        $obj = [];

        foreach($this->publicFields as $fieldname)
        {
            $obj[$fieldname] = $this->fields[$fieldname];
        }
        return json_encode($obj);
    }
}
