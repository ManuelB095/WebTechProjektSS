<?php

class Model extends DB
{
    /*
    |------------------------------------------------
    | Variables
    |------------------------------------------------
    */

    private $primary_key_column;
    private $table;
    private $fields = [];

    /*
    |------------------------------------------------
    | Magic Methods
    |------------------------------------------------
    */

    function __get($field)
    {
        return $this->fields[$field];
    }

    function __set($field, $value)
    {
        if( $field == $this->primary_key_column )
        {
            assert(FALSE, "Attempt to set primary key $field to $value .");
        }
        $this->fields[$field] = $value;
    }

    /*
    |------------------------------------------------
    | Use Functions
    |------------------------------------------------
    */

    // Gets ALL Data from given table ( for example: User-Table and stores it in $this->field)
    protected function AutoFillByKeyValue($table, $key, $value)
    {
        $this->table = $table;
        $this->primary_key_column = $key;
        $db = new DB();
        //TODO this is unsecured and also doesn't use the DB class
        // We could try to simply make Model extends DB
        // Using prepared statements instead:
         $sql = "SELECT * FROM $table WHERE $key = ?";
         $stmt = $db->pdo->prepare($sql);
         $stmt->execute([$value]);
        $stmt = $db->pdo->query("SELECT * FROM $table WHERE $key = '$value';");
        
        /* Metadata includes type &c. If we want automated type validation, this will come in handy.
        for($i = 0; $i<$stmt->columnCount(); ++$i)
        {
            $meta = $stmt->getColumnMeta($i);
            $this->fields[$meta['name']] => ;
        }
        */

        foreach($stmt->fetch() as $column => $field)
        {
            if( gettype($column) == 'string') // QUESTION: What exactly is the importance of checking this ?
            {
                $this->fields[ $column ] = $field;
            }
        }
        print "<br>";
        var_dump($this->fields);
        return TRUE;
    }

    // Pushes changes made to the object ( $this->field) to the given DataBase
    protected function PushChanges()
    {
        /*TODO 'UPDATE' the DB */
        // Could not get this to work properly somehow. Think it has something to do with the named placeholders being :column.
         $db = new DB();
         $primKey = $this->primary_key_column;
         $sql = "UPDATE $this->table SET ";
         foreach($this->fields as $column => $field)
        {
            if( $column != $primKey )
            {
                $placeholder = ":" . $column;
                $sql .= "$column = $placeholder ";
                $sql .= ",";
            }
        }
        $sql = substr($sql,0,-1);
        $sql .= "WHERE $primKey = :ex_username";
        print "<br>";
        print $sql;
        print "<br>";
        $stmt = $db->pdo->prepare($sql);
        foreach($this->fields as $column => $field)
        {
            if( $column != $primKey)
            {
                $stmt->bindParam(':'. $column, $field);
                print ':' . $column . '<br>';
                print '   ' . $field;
            }     
        }
        $stmt->bindParam(':'. $primKey, $this->fields[$primKey] );
        print ':'. $primKey;
        $stmt->execute();   
    }

    protected function pushAsNewEntry(array $values)
    {
        $db = new DB();
        $primKey = $this->primary_key_column;
        $sql = "INSERT INTO $this->table ( ";
        foreach ($this->fields as $column => $field)
        {
            
            $placeholder = ":" . $column;
            $sql .= "$placeholder ";
            $sql .= ",";
            print "Placeholder: " .$placeholder . "<br>";
            
        }
        $sql = substr($sql,0,-1);
        $sql .= ')';
        $sql .= " VALUES (";
        foreach ($values as $value)
        {
            $placeholder = ":" . $value;
            $sql .= $placeholder;
            $sql .= ","; 
            print "Value-Placeholder: " . $placeholder . "<br>";   
        }
        $sql = substr($sql,0,-1);
        $sql .= ");";

        print "<br>SQL: " . $sql . "<br>";
        $stmt = $db->pdo->prepare($sql);
        foreach ($this->fields as $column => $field)
        {
            $stmt->bindParam(':'. $column, $field);
            print "Bind: " . ':' . $column . "with " . $field . "<br>";
            // print ':' . $column . '<br>';
            // print '   ' . $field;
            
        }
        var_dump($values);
        foreach ($values as $value)
        {
            $stmt->bindParam(':' . $value, $value);  
            print "Bind: " . ':' . $value . "with Value " . $value . "<br>";
        }
        // $stmt->bindParam(':'. $primKey, $this->fields[$primKey] );
        // print "Bind: " . ':' . $primKey . "with " . $this->fields[$primKey];

        $stmt->execute();
    }
}
