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

    /*
    |------------------------------------------------
    | Main Functions
    |------------------------------------------------
    */

    public function createUser($assArray)
    {
      // Error Handling 
       $this->checkArgumentCount($assArray); // Too many arguments ? ( Here > 11 )
       $this->lookForNecessarys($assArray); // Necessary Fields included ? ( Here 7)
       $this->checkIfWhitelisted($assArray); // Rest of the fields white-listed ?
       $this->hashPWIn($assArray);
       $this->autoNullMissingFields($assArray); //PHPMyAdmin does this by default; Maybe exlude ?
      // Only access database if no error occured.
        if($this->error <= 0)
        {
            echo "<br>SET USER IS PROCESSED<br>";
            $this->setUser($assArray);
        }
    }

    public function editUser($assArray, $username = null) // OPTIONAL : Include Primary Key in array OR as extra variable
    {
      // Error Handling
        $this->checkArgumentCount($assArray);
        $this->checkIfWhitelisted($assArray);
        $this->hashPWIfNecessary($assArray);

      // Check if optional is given and prepare accordingly
        if($username != null && !array_key_exists($this->PK,$assArray))
        {
            $assArray[$this->PK] = $username;
        }
        else if($username != null && array_key_exists($this->PK,$assArray))
        {
            $this->error += 1;
            array_push($this->errorMsg, "ERROR: Primary Key '" . $this->PK ."' is already in \$assArray<br>");         
        }

      // Only access database if no error occured.
         if($this->error <= 0)
         {
             echo "<br>SET USER IS PROCESSED<br>";
             $this->updateUser($assArray);
         }
    }

    // QUESTION: Do we need a Delete User too ?
    public function hashPWIfNecessary(&$assArray)
    {
        $submittedKeys = array_keys($assArray);
        if(array_key_exists('password', $assArray))
        {
            $hashedPW = $this->getHashedPassword($assArray['password']);
            print "Hashed :" . $hashedPW . "<br>";
            $assArray['password'] = $hashedPW;
        }
    }

    public function hashPWIn(&$assArray)
    {
        if(!array_key_exists('password', $assArray))
        {
            $this->error += 1;
            array_push($this->errorMsg, "ERROR: No 'password' field in \$assArray<br>");     
        }
        else
            $this->hashPWIfNecessary($assArray);
    }

    public function getHashedPassword($pwd=''){
        return password_hash($pwd, PASSWORD_DEFAULT); // returns 60 digit of hex chars
    }

    private function isPasswordCorrect($hashedPW, $PWfromDB)
    {
        return password_verify($hashedPW, $PWfromDB); // Verify that typed password/Username Combination is the same as the ( hashed one in the database )
    }


    /*
    |------------------------------------------------
    | Error Handling Section
    |------------------------------------------------
    */
    public function checkIfUserExists($username)
    {
        $results = $this->getUser($username);
        if($results[$this->PK] != $username)
        {

        }
    }

    public function lookForNecessarys($assArray)
    {
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
    }

    public function checkIfWhitelisted($assArray)
    {
        $submittedKeys = array_keys($assArray);
        foreach($submittedKeys as $key)
        {
            if(!in_array($key, $this->whiteList))
            {
                $this->error += 1;
                array_push($this->errorMsg, "ERROR: Argument '" . $key ."' of \$assArray not in whitelist !<br>");     
                break;
            }
        }
    }

    public function checkArgumentCount($assArray)
    {
        if(count($assArray) > $this->fieldSize)
        {
            $this->error += 1;
            array_push($this->errorMsg, "ERROR: Too many arguments for \$userInformation !<br>");
        }
    }

    public function autoNullMissingFields($assArray)
    {
        foreach($this->whiteList as $key)
        {
          // If too few ( non-necessarys ) arguments are given, stock up the remaining ones with null
            if(!array_key_exists($key, $assArray))
            {
                $assArray[$key] = ""; // For some reason = NULL does not work with phpMyAdmin
            }
        }
    }

    // !! ATTENTION !! 
    // PHP seems to take care of this one themselves and just does not save duplicates in the first place
    // This means, that it is not really possible to catch this error
    /* public function checkForDuplicates($assArray)
    // {
    //   // CKey = Compare Key; Ikey = Iterate Key
    //     var_dump($assArray);
    //     $submittedKeys = array_keys($assArray);
    //     foreach($submittedKeys as $Ckey)
    //     {
    //         $CKeyCount = 0;
    //         foreach($submittedKeys as $Ikey)
    //         {
    //             if($Ckey == $Ikey)
    //             {
    //                 ++$CKeyCount;
    //             }
    //             if($CKeyCount > 1) // Same Key is in array more than once
    //             {
    //                 $this->error += 1;
    //                 array_push($this->errorMsg, "ERROR: Double-entry for '".$Ckey."' in \$assArray !<br>");
    //             }
    //         }
    //         print "CKEY ". $Ckey . $CKeyCount . "<br>";

    //     }
    // } */

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