<?php

// This is meant as a rough blueprint, documenting how and why this class (family) works.
// Copy and repurpose according to your needs.
class Model extends DB{

    protected $table; // Example: 'users' for the Users, 'products' for Products etc.
    protected $PK; // Primary Key of the table
    protected $whiteList = []; // Contains the allowes attributes for the given table

    // TO DO List:
    // getUser("Username");
    // setUser("Username", array with values); == update User
    // ...

    function __construct()
    {
        $this->table = "";
        $this->PK = ""; 
    }

    function __get($var)
    {
        return $var;
    }

    function __set($var, $value)
    {
        // TO DO
    }

    protected function getTableEntry($primaryKeyHere) // Rename for given purpose; Receives row data
    {
        $sql = "SELECT * FROM $this->table WHERE $primaryKeyHere = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$primaryKeyHere]);
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function setTableEntry($entryInformation) // Rename for given purposes; Inserts row data; $entryInformation shall be associative array
    {
        $keys = array_keys($entryInformation);
        $sql = "INSERT INTO users (".implode(", ",$keys).") \n";
        $sql .= "VALUES ( :".implode(", :",$keys).")";        
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($entryInformation);
        print "Did something happen ?";
        print "SQL:". $sql ."<br>";
    }

}

?>