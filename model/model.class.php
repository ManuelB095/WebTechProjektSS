<?php

// This is meant as a rough blueprint, documenting how and why this class (family) works.
// Copy and repurpose according to your needs.
class Model extends DB{

    protected $table; // Example: 'users' for the Users, 'products' for Products etc.
    protected $PK; // Primary Key of the table
    protected $fieldSize; // How many fields are in the given database ( Error Handling )
    protected $whiteList = []; // Contains the allowed attributes for the given table
    protected $necessarys = []; // Contains necessary attributes for a new entry in the table

    // TO DO List:
    // getUser("Username");
    // setUser("Username", array with values); == update User
    // ...

    function __construct()
    {
        $this->table = "";
        $this->PK = ""; 
        $this->fieldSize = -1; 
    }

  // If you want to change table and attributes manually, you 'can' do that in the code with magic methods
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
        $sql = "SELECT * FROM $this->table WHERE".$this->PK." = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$ex_username]);
        $results = $stmt->fetchAll(); // QUESTION: Should we change this to FETCH::CLASS, like Tim suggested and save them as member variables ?
        return $results;
    }

    protected function setUser($userInformation)
    {
        $keys = array_keys($userInformation);
        $sql = "INSERT INTO ".$this->table."(".implode(", ",$keys).") \n"; 
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
    protected function updateUser($userInformation) // columns are $userInformation keys;fields are $userInformation values
    {
        $keys = array_keys($userInformation);
        $values = array_values($userInformation);
      // UPDATE Statement
        $sql = "UPDATE ". $this->table;
      // SET Statement
        $SETStmt = " SET ";
        foreach($keys as $key)
        {
            if($key != $this->PK)
            {
                $SetSubStmt = $key." = ".":".$key . ", "; // ex.: 'firstname = :value, '
                $SETStmt .= $SetSubStmt;
            }
        }
        $sql .= $SETStmt;
        $sql = substr($sql, 0, -2); // -2 for the space after ','
      // WHERE Statement
        $WHEREStmt = " WHERE ".$this->PK." = :".$this->PK;
        $sql .= $WHEREStmt;
        echo "UPDATE-SQL-STATEMENT: <br>";
        echo $sql;
      // Prepare FUll SQL
        $stmt = $this->connect()->prepare($sql);

        // Should this be in UserControl ? Lelt`s leave it be for now..
        // if($username == null && !array_key_exists($this->PK, $userInformation))
        // {
        //     // throw error
        //     //$userInformation[$this->PK] = $username;
        // }
        // else if($username != null && arra_key_exists($this->PK, $userInformation))
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