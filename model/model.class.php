<?php

class Model
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

    protected function AutoFillByKeyValue($table, $key, $value)
    {
        $this->table = $table;
        $this->primary_key_column = $key;
        $db = new DB();
        //TODO this is unsecured and also doesn't use the DB class
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
            if( gettype($column) == 'string')
            {
                $this->fields[ $column ] = $field;
            }
        }
        return TRUE;
    }

    protected function PushChanges()
    {
        /*TODO 'UPDATE' the DB
        $sql = "UPDATE $table SET ";
        foreach($this->fields as $column => $field)
        {
            if( $column != $this->primary_key_column )
            {
                $sql .= "$column = :$column ";
            }
        }
        $sql .= "WHERE $primary_key_column = :$primary_key_column";
        $stmt = $db->prepare($sql);
        foreach($this->fields as $column => $field)
        {
            $stmt->bindParam(':'. $column, $field);
        }
        $stmt->execute();
        */
    }
}
