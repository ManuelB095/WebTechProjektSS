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

    protected function IsBoughtBy($username)
    {
        if(empty( $username ) || !$this->exists) { return false; }
echo "$username<br>\n";
        $db = new DB('SELECT COUNT(*) FROM userboughtproduct WHERE b_username = :username AND b_pid = :pid');
        $count = $db->Fetch([
            'username' => $username,
            'pid' => $this->pid,
        ]);

        return !empty($count[0]['COUNT(*)']);
    }

    protected function extendPreJSON(&$obj)
    {
        if(empty( $_SESSION['username'] ))
            { $obj['access'] = 0; }
        elseif( $_SESSION['username'] == $this->pr_owner )
            { $obj['access'] = 2; }
        elseif( $this->IsBoughtBy($_SESSION['username']) )
            { $obj['access'] = 1; }
        else
            { $obj['access'] = 0; }

        if( $obj['access'] == 0 && empty($_SESSION['is_admin']) )
        {
            // If the user has no right to this file, don't give out classified information.
            unset( $obj['pr_filename'] );
        }

        $db = new DB('SELECT tid FROM producttags WHERE pid = :pid');
        $results = $db->Fetch([
            'pid' => $this->pid,
        ]);

        $obj['tags'] = [];
        foreach($results as $line)
        {
            array_push( $obj['tags'], $line['tid'] );
        }
    }

}
