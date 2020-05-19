<?php

class UserControl extends User{

    private $error;
    private $errorMsg;

    function __construct()
    {
        parent::__construct();
        $this->error = 0;
        $this->errorMsg = array();
    }

  // TO DO: Checks in dedicated functions
    public function createUser($assArray)
    {
        if(count($assArray) > 11)
        {
            $this->error += 1;
            array_push($this->errorMsg, "ERROR: Too many arguments for \$userInformation !<br>");
        }

      // Check for necessarys and throw error if not in here; Try/catch and throw here instead ?
        foreach($this->necessarys as $key)
        {
            if(!array_key_exists($key, $assArray))
            {
                $this->error += 1;
                array_push($this->errorMsg, "ERROR: Necessary field '" . $key ."' is missing from \$assArray<br>");
                
                break;
            }
        }
        echo "NECESSARYS: <br>";
        var_dump($assArray);

        foreach($this->whiteList as $key)
        {
          // If too few ( non-necessarys ) arguments are given, stock up the remaining ones with null
            if(!array_key_exists($key, $assArray))
            {
                $assArray[$key] = ""; // For some reason = NULL does not work with phpMyAdmin
            }
        }
        $submittedKeys = array_keys($assArray);
        echo "Submitted Keys<br>";
        var_dump($submittedKeys);
        foreach($submittedKeys as $key)
        {
            if(!in_array($key, $this->whiteList))
            {
                $this->error += 1;
                array_push($this->errorMsg, "ERROR: Argument '" . $key ."' of \$assArray not in whitelist !<br>");     
                break;
            }
        }
        
        echo "WHITELIST: <br>";
        var_dump($this->whiteList);
      // Only access database if no error occured.
        if($this->error <= 0)
        {
            echo "<br>SET USER IS PROCESSED<br>";
            $this->setUser($assArray);
        }
    }

  // TO DO: updateUser($username, $assArray)
    public function editUser($assArray, $username = null)
    {
        $this->updateUser($assArray);
    }

    public function checkNecessarys()
    {

    }

    public function checkWhitelist()
    {

    }

    public function showErrors()
    {
        var_dump($this->errorMsg);

        if($this->error != 0)
        {
            print '<err>';echo "<br>";
            for($k=0;$k<$this->error;++$k)
            {
                echo "(".$k.")<br>";
                echo $this->errorMsg[$k];
            }
            print '</err>';echo "<br>";
        }
        else
            echo "0 Errors. Program executed successfully.<br>";       
    }
}




?>