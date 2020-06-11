<?php

// only if logged in
if(empty( $_SESSION['username'] ))
{
    echo "Not logged in.";
    return;
}


// retrieve sanitised inputs
$pid = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT);
$colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_NUMBER_INT);
$scale = filter_input(INPUT_POST, 'scale', FILTER_SANITIZE_NUMBER_INT);


//TODO magic
// notes: PID can be a json-encoded array if multiple images were selected. Compare to "/controller/deleteproduct.php" and "/controller/createshopcart.php" for examples.
// notes: colour is actually bool
// notes: client currently assumes JSON response, can be changed if it screws download up
// notes: scale is an int 1 - 100


echo "true"; // wenn erfolgreich? könnte mit Download im Konflikt stehen
