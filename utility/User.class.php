<?php

class User extends DB{

    protected $table;
    protected $PK;
    protected $whiteList = ["username", "password", "email", "title", "firstname", "lastname", 
    "address", "location", "plz", "is_admin", "is_active"];

    // TO DO List:
    // getUser("Username");
    // setUser("Username", array with values); == update User
    // ...

    function __construct()
    {
        $this->table = "users";
        $this->PK = "username"; 
    }

    function __get($var)
    {
        return $var;
    }

    function __set($var, $value)
    {
        // TO DO
    }

    protected function getUser($ex_username)
    {
        $sql = "SELECT * FROM $this->table WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ex_username]);
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function setUser($userInformation)
    {
        $keys = array_keys($userInformation);
        $sql = "INSERT INTO users (".implode(", ",$keys).") \n";
        $sql .= "VALUES ( :".implode(", :",$keys).")";        
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($userInformation);
        print "Did something happen ?";
        print "SQL:". $sql ."<br>";
    }

}



?>