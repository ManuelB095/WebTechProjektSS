<?php

class UserView extends User{

    public function showUser($username)
    {
        $results = $this->getUser($username);
        echo "Firstname: " . $results[0]['firstname'] . "<br>";
        echo "Lastname: " . $results[0]['lastname'] . "<br>";

        var_dump($results);
    }

    // TO DO: 
    //1. This belongs to UserControl
    //2. CHECK FOR : Too few arguments given
    //3. CHECK FOR : NOT Enough (importants like Password, etc.) given
    //4. If something left empty ( that is allowed to be NULL ) show at least a message
    public function createUser($assArray)
    {
        if(count($assArray) > 11)
        {
            echo "Too many arguments for \$userInformation !<br>";
        }

        foreach($this->whiteList as $key)
        {
            if(!array_key_exists($key, $assArray))
            {
                $userInformation[$key] = NULL;
            }
        }
        $this->setUser($assArray);
        print "Hallou ?";
    }

    // TO DO: updateUser($username, $assArray)

}


?>