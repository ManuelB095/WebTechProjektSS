<?php

/*
|------------------------------------------------
| The DB class
|------------------------------------------------
|
| Here is the gist of this class:
|
| You know how SQL works.
| Only you know what SQL you need.
|
| You don't need to know how exactly PDO
| or the connection stuff works.
| DB knows the connection you need.
|
*/

class DB
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    private $pdo;
    private $stmt;

    /*
    |------------------------------------------------
    | Functions
    |------------------------------------------------
    */

    function __construct($sql) //, $paramsets)
    {
        // phase 1: connect

        $connection_string = Config('database','driver');
        $connection_string .= ':host='. Config('database','host');
        $connection_string .= ';dbname='. Config('database','database');
        if( !empty(Config('database','charset')) )
        {
            $connection_string .= ';charset='. Config('database','charset');
        }
        try {
            $this->pdo = new PDO($connection_string, Config('database','username'), Config('database','password'));
        }
        catch(PDOException $e)
        {
            //TODO SECURITY: For all error printings in this file, only do it in dev/debug mode! -LG
            print "ERROR (DB connecting): $connection_string\n";
            print $e->getMessage();
            return false;
        }
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // phase 2: prepare

        try
        {
            $this->stmt = $this->pdo->prepare($sql);
        }
        catch(PDOException $e)
        {
            print "ERROR (DB preparing): $sql\n";
            print $e->getMessage();
            return false;
        }

        // phase 3: bind & execute
        /*

        foreach($paramsets as $paramset)
        {
            // bind

            foreach($paramset as $key => $value)
            {
                try
                {
                    $this->stmt->bindValue($key, $val);
                }
                catch(PDOException $e)
                {
                    print "ERROR (DB binding): $key => $value";
                    print $e->getMessage();
                    return false;
                }
            }

            // execute

            try
            {
                $this->stmt->execute();
            }
            catch(PDOException $e)
            {
                print "ERROR (DB executing): $sql\n";
                var_dump($paramset);
                print $e->getMessage();
                return false;
            }
        }

        // phase 4: fetch
        //TODO is there such a thing as fetching for several paramsets? should we account for that? -LG

        return $this->stmt->fetchAll(); //TODO doesn't work on constructor
        */
    }

    public function Fetch($paramset)
    {
        // phase 3: bind

        foreach($paramset as $key => $value)
        {
            try
            {
                $this->stmt->bindValue($key, $value);
            }
            catch(PDOException $e)
            {
                print "ERROR (DB binding): $key => $value\n";
                print $e->getMessage();
                return false;
            }
        }

        // phase 4: execute

        try
        {
            $this->stmt->execute();
        }
        catch(PDOException $e)
        {
            print "ERROR (DB executing): \n";
            var_dump($paramset);
            print $e->getMessage();
            return false;
        }

        // phase 5: fetch

        return $this->stmt->fetchAll();
    }
}
