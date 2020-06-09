<?php

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);

if(empty( $username ))
{
    echo "No username given";
    return;
}

$response = [];

$db = new DB("
SELECT b_pid, pr_filename
FROM userboughtproduct 
LEFT JOIN products ON b_pid = pid
WHERE b_username = :b_username
");

$results = $db->Fetch([
    'b_username' => $username,
]);

foreach($results as $line)
{
    array_push($response, [
        $line['b_pid'],
        $line['pr_filename'],
    ]);
}

echo json_encode($response);

