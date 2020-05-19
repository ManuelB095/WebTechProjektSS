<?php

class UserView extends User{

    public function showUser($username)
    {
        $results = $this->getUser($username);
        echo "Firstname: " . $results[0]['firstname'] . "<br>";
        echo "Lastname: " . $results[0]['lastname'] . "<br>";

        var_dump($results);
    }

    

}


?>