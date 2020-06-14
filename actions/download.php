<?php

// only if logged in
if(empty( $_SESSION['username'] ))
{
    //TODO the AJAX needs to actually fail (error code) to display errors in this file
    //echo "Not logged in.";
    return;
}


// retrieve sanitised inputs
$inputjson = filter_input(INPUT_POST, 'pid', FILTER_UNSAFE_RAW);

$input = json_decode($inputjson);

// batch-download in a single request
if( !empty($input) && gettype($input) == 'array' )
{
    $errors = [];

    $zip = new ZipArchive();
    $zipname = Config('app','name') .'-Download-'. uniqid() .'.zip';
    if( !$zip->open( $zipname, ZIPARCHIVE::CREATE ) )
    {
        //echo "Failed to create ZIP. Try again later or contact the system administrator.";
        return;
    }

    $db_pr = new DB("SELECT pr_owner, pr_filename FROM products WHERE pid = :pid");
    $db_bought = new DB("SELECT COUNT(*) FROM userboughtproduct WHERE :pid = :pid AND b_username = :username");
    foreach($input as $pos => $raw)
    {
        $pid = filter_var($raw, FILTER_SANITIZE_NUMBER_INT);

        $results_pr = $db_pr->Fetch([
            'pid' => $pid,
        ]);

        // verify current user has privilege to download
        if( !$_SESSION['is_admin'] && $results_pr['pr_owner'] != $_SESSION['username'] )
        {
            $results_bought = $db_bought->Fetch([
                'b_pid' => $pid,
                'b_username' => $_SESSION['username'],
            ]);
            if( $results_bought[0] < 1 )
            {
                $errors[$pos] = "$pid: No permission.";
                continue;
            }
        }

        $zip->addFile(
            "ugc/full/$pid/{$results_pr[0]['pr_filename']}", // src name
            "$pid - {$results_pr[0]['pr_filename']}", // zipped name
        );
    }
    $zip->close();

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'. $zipname .'"');
    header('Content-Length: '. filesize($zipname) );
    header('Content-Transfer-Encoding: binary');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    flush(); // sends all up until now, clearing buffer in the process

    readfile($zipname); // echo
    unlink($zipname); // In theory, unlink only removes the main reference, letting the filesystem clean up once all other references are gone (i.e. download finished). In practise, I believe PHP actually deletes the file but keeps a copy in the output buffer. -LG

    //echo json_encode($errors);
}
// allow single-download by double-checking the input field
elseif(!empty( $pid = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT) ))
{
    // retrieve sanitised inputs
    //$pid = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT);
    $colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_NUMBER_INT); // bool 0 - 1
    $scale = filter_input(INPUT_POST, 'scale', FILTER_SANITIZE_NUMBER_INT); // int 1 - 100


    //TODO test and implement filter magic

    $db = new DB("SELECT pr_owner, pr_filename FROM products WHERE pid = :pid");

    $results_pr = $db->Fetch([
        'pid' => $pid,
    ]);

    // verify current user has privilege to download
    if( !$_SESSION['is_admin'] && $results_pr[0]['pr_owner'] != $_SESSION['username'] )
    {
        $db = new DB("SELECT COUNT(*) FROM userboughtproduct WHERE b_pid = :b_pid AND b_username = :b_username");
        $results_bought = $db->Fetch([
            'b_pid' => $pid,
            'b_username' => $_SESSION['username'],
        ]);
        if( $results_bought[0]['COUNT(*)'] < 1 )
        {
            //echo "No permission.";
            return;
        }
    }

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'. $results_pr[0]['pr_filename'] .'"');
    header('Content-Length: '. filesize("ugc/full/$pid/{$results_pr[0]['pr_filename']}") );
    header('Content-Transfer-Encoding: binary');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    //header('Pragma: public');

    flush(); // sends all up until now, clearing buffer in the process

    readfile("ugc/full/$pid/{$results_pr[0]['pr_filename']}"); // echo


    //echo "true";
}
else
{
    //echo "No products selected.";
    return;
}
