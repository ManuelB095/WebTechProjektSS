<?php

class Product extends Model
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    const publicFields = ["pid", "pr_pwner", "pr_filename", "pr_exif", "pr_upload_date", "pr_quality", "pr_creation_date"];

    /*
    |------------------------------------------------
    | Magic Methods
    |------------------------------------------------
    */

    function __construct($pid)
    {
        //ctor
        $this->AutoFillByKeyValue('products','pid',$pid);
    }

    /*
    |------------------------------------------------
    | Use Functions
    |------------------------------------------------
    */

    protected function extendPreJSON($obj)
    {
        $obj['access'] = 1; //TODO get access privileges of logged in user
    }

}
