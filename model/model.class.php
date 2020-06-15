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
    protected $fields = [];
    protected $exists = FALSE;

    /*
    |------------------------------------------------
    | Magic Methods
    |------------------------------------------------
    */

    /*
    function __destruct()
    {
        //dtor

        // Do not save automatically, it may have been a read-only anyways
        //$this->SaveChanges();
    }
    */

    function __get($field)
    {
        if( $field == 'exists' ) return $this->exists;
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
        $db = new DB("SELECT * FROM {$this->table} WHERE $key = :value ");
        $fetched = $db->Fetch(['value'=>$value]);

        if(empty( $fetched ))
        {
            return FALSE;
        }

        assert( count($fetched) < 2 );
        
        /* Metadata includes type &c. If we want automated type validation, this will come in handy.
        for($i = 0; $i<$pdo_statement->columnCount(); ++$i)
        {
            $meta = $pdo_statement->getColumnMeta($i);
            $this->fields[$meta['name']] => ;
        }
        */
        
        $this->exists = TRUE;

        foreach($fetched[0] as $column => $field)
        {
            if( gettype($column) == 'string')
            {
                $this->fields[ $column ] = $field;
            }
        }
        return TRUE;
    }

    public function SaveChanges()
    {
        $sql = "UPDATE {$this->table} SET ";
        $stupidcommabool = true;
        foreach($this->fields as $column => $field)
        {
            if( $column != $this->primary_key_column )
            {
                if( $stupidcommabool )
                {
                    $stupidcommabool = false;
                }
                else
                {
                    $sql .= ", ";
                }
                $sql .= "$column = :$column ";
            }
        }
        $sql .= "WHERE {$this->primary_key_column} = :{$this->primary_key_column}";
        $db = new DB($sql);
        $db->Execute($this->fields);
    }

    public function getJSON()
    {
        if( !$this->exists ) return;

        $obj = [];
        $fields = array_keys($this->fields);

        if(isset( self::$publicFields ))
        {
            //TODO Maybe blacklist ("hiddenFields") instead of whitelist? -LG
            // May omit more fields under circumstances in extendPreJSON -LG
            $fields = self::$publicFields;
        }

        foreach( $fields as $fieldname )
        {
            $obj[$fieldname] = $this->fields[$fieldname];
        }
        
        if( method_exists($this, 'extendPreJSON') )
        {
            $this->extendPreJSON($obj);
        }

        return json_encode($obj);
   }
}
