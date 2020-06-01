<?php

$limit = filter_input(INPUT_POST, 'limit', FILTER_SANITIZE_NUMBER_INT);
if(empty( $limit ))
{
    $limit = 6;
}
else
{
    // Wir sind am absoluten Limit angelangt. -LG
    $limit = min( abs($limit), 30 );
}

//$feed = [];
$db = new DB("SELECT pid, pr_upload_date FROM products ORDER BY pr_upload_date DESC LIMIT $limit");
/*$results = $db->Fetch();
foreach($results as $line)
{
    array_push($feed, $line['pid']);
}
return $feed;*/

return $db->Fetch();

