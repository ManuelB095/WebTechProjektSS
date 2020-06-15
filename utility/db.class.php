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

    function __construct($sql, $is_transaction = false)
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
            if( Config('app','debug') )
            {
                print "ERROR (DB connecting): $connection_string\n";
                print $e->getMessage();
            }
            else
            {
                print "Database error (Connection), please try again later or call the system administrator.";
            }
            return false;
        }
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        // phase 1.5: transaction
        if( $is_transaction )
        {
            $this->pdo->beginTransaction();
        }

        // phase 2: prepare

        try
        {
            $this->stmt = $this->pdo->prepare($sql);
        }
        catch(PDOException $e)
        {
            if( Config('app','debug') )
            {
                print "ERROR (DB preparing): $sql\n";
                print $e->getMessage();
            }
            else
            {
                print "Database error (Preparing), please call the system administrator.";
            }
            return false;
        }
    }

    public function Execute($paramset = [])
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
                if( Config('app','debug') )
                {
                    print "ERROR (DB binding): $key => $value\n";
                    print $e->getMessage();
                }
                else
                {
                    print "Database error (missing, invalid or too much input). Please call the system administrator.";
                }
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
            if( Config('app','debug') )
            {
                print "ERROR (DB executing): \n";
                var_dump($paramset);
                print $e->getMessage();
            }
            else
            {
                print "Database error (executing). Please call the system administrator.";
            }
            return false;
        }
    }

    public function Fetch($paramset = [])
    {
        $this->Execute($paramset);

        // phase 5 (select): fetch

        return $this->stmt->fetchAll();
    }

    public function lastInsertID()
    {
        // phase 5 (insert): get (generated) primary key

        return $this->pdo->lastInsertID();
    }

    public function commit()
    {
        // phase 5.5: commit changes

        return $this->pdo->commit();
    }
}
