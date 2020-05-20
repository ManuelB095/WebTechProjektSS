<?php

class User extends DB{

    protected $table;
    protected $PK;
    protected $fieldSize; // How many fields are in the given database ( Error Handling )
    protected $whiteList = ["username", "password", "email", "title", "firstname", "lastname", 
    "address", "location", "plz", "is_admin", "is_active"];
    protected $necessarys = ["username", "password", "firstname", "lastname", "address", "is_admin", "is_active"];

    // TO DO List:
    // getUser("Username");
    // setUser("Username", array with values); == update User
    // ...

    function __construct()
    {
        $this->table = "users";
        $this->PK = "username"; 
        $this->fieldSize = 11;
    }

    function __get($var)
    {
        return $var;
    }

    function __set($var, $value)
    {
        $this->var = $value;
    }

    protected function getUser($ex_username)
    {
        $sql = "SELECT * FROM $this->table WHERE username = ?"; // TO DO: Re-Write and Debug to $this->PK
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ex_username]);
        $results = $stmt->fetchAll();
        return $results;
    }

    protected function setUser($userInformation)
    {
        $keys = array_keys($userInformation);
        $sql = "INSERT INTO users (".implode(", ",$keys).") \n"; // To DO: Change users to $this->table and Debug
        $sql .= "VALUES ( :".implode(", :",$keys).")";        
        $stmt = $this->connect()->prepare($sql);
        print "UserInfo<br>";
        var_dump($userInformation);
        $stmt->execute($userInformation);
        print "<br>SQL:". $sql ."<br>";
    }

    // TO DO: Make Code less clunky and format sql better
    // 1. Add Comments
    // 2. De-Clunkify Code for better reading
    // 3. Provide Error-Handling ( see To DO in UserControl) here or possibly in UserControl class
    // 4. Implement optional parameter $username and throw errors accordingly
    protected function updateUser($userInformation, $username = null) // columns are $userInformation keys;fields are $userInformation values
    {
        $keys = array_keys($userInformation);
        $values = array_values($userInformation);
        $sql = "UPDATE ". $this->table ." SET ";
        foreach($keys as $key)
        {
            if($key != $this->PK)
            {
                $setStmt = $key." = ".":".$key . ", "; // ex.: 'firstname = :value, '
                $sql .= $setStmt;
            }
        }
        $sql = substr($sql, 0, -2); // -2 for the space after ','
        $WHEREStmt = " WHERE ".$this->PK." = :".$this->PK;
        $sql .= $WHEREStmt;
        echo "UPDATE-SQL-STATEMENT: <br>";
        echo $sql;
        $stmt = $this->connect()->prepare($sql);
        // Should this be in UserControl ? Lelt`s leave it be for now..
        // if($username == "given" && !array_key_exists($this->PK, $userInformation))
        // {
        //     // throw error
        //     //$userInformation[$this->PK] = $username;
        // }
        // else if($username != "given" && arra_key_exists($this->PK, $userInformation))
        // {
        //     // throw another error
        // }
        echo "<br>";
        echo "UPDATE \$userInfo: <br>";
        var_dump($userInformation);
        $stmt->execute($userInformation);
        
    }

}



?>