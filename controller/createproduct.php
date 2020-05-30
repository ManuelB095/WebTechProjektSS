<?php

/*
|------------------------------------------------
| Validation
|------------------------------------------------
*/

// Only if logged in TODO
if(empty( $_SESSION['username'] ))
{
    //return "Not logged in.";
}

// From former "UserControl": make sure there are no unknown inputs?

// Has anything been received?
if(empty( $_FILES['productfile'] ))
{
    return "No file received.";
}
$file = $_FILES['productfile'];

// Did PHP notice any errors?
if ($file["error"] !== UPLOAD_ERR_OK)
{
    return "Upload failed (code {$file["error"]}).";
}

// Is the file empty?
if(empty( $file['name'] ) || empty( $file['size'] ) || $file["size"] < 12 )
{
    // 12 bytes are necessary for the magic number, else the file is definitely useless.
    return "File is empty.";
}
$sourcefilename = filter_var($file["name"], FILTER_SANITIZE_STRING);

// Is the file too large? (20MB is plenty, right?)
if ($file["size"] > 20000000)
{
    return "File is too large. Try saving as JPG or reducing resolution.";
}

// Get magic number
$file_info = getimagesize($file["tmp_name"]);

const imageTypes = [
    IMAGETYPE_GIF => "ImageCreateFromGIF",
    IMAGETYPE_JPEG => "ImageCreateFromJPEG",
    IMAGETYPE_PNG => "ImageCreateFromPNG",
    IMAGETYPE_BMP => "ImageCreateFromBMP",
    IMAGETYPE_WEBP => "ImageCreateFromWEBP",
];

// Is the file a valid image (TODO compare to blueimp for this?)
if(empty( preg_match("/.*\.(jpg|jpeg|png|gif|webp|bmp)$/i", $sourcefilename) ) || empty( imageTypes[$file_info[2]] ))
{
    return;
}

/*
|------------------------------------------------
| DB Entry
|------------------------------------------------
*/

$input = [
    'pr_owner' => 'asdf', //TODO current user
    'pr_filename' => $sourcefilename,
    'pr_exif' => '', //TODO geo data
    'pr_upload_date' => date('Y-m-d H:i:s'),
    'pr_quality' => '', //TODO meta data
    'pr_creation_date' => date('Y-m-d H:i:s'), //new DateTime('2001-01-31 06:40:00')->format('Y-m-d H:i:s'), //TODO meta data (default to current?)
];

$keys = array_keys($input);
$db = new DB("INSERT INTO products(". implode(', ', $keys) .") VALUES(:". implode(', :', $keys) .")", true);
$db->Execute($input);

/*
|------------------------------------------------
| File Storage
|------------------------------------------------
*/

$pid = $db->lastInsertId();

// Prepare the file storage
if (!is_dir("ugc/full/$pid"))
{
    mkdir("ugc/full/$pid");
}

if( move_uploaded_file($file["tmp_name"], "ugc/full/$pid/$sourcefilename") )
{
    //echo "Upload erfolgreich! Das Bild heißt $sourcefilename");

    //Imagick Zeug für Thumbnails, echt coole API
    /*
    $imagick = new Imagick(realpath("ugc/full/$pid/$sourcefilename"));
    $imagick->setImageFormat('jpg');
    $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
    $imagick->setImageCompressionQuality(90);
    $imagick->thumbnailImage(300, 250, false, false);
    file_put_contents("ugc/thumb/$pid.jpg", $imagick);
    */

    //Imagick-lose Lösung, falls Imagick nicht installiert ist
    $old_image = imageTypes[$file_info[2]]("ugc/full/$pid/$sourcefilename");
    $new_image = imagecreatetruecolor(300, 250);
    imagecopyresized($new_image, $old_image, 0, 0, 0, 0, 300, 250, $file_info[0], $file_info[1]);
    imagejpeg($new_image, "ugc/thumb/$pid.jpg");
}
else // should never happen
{
    return "File could not be stored in the UGC folder. System administrator, please stop messing with the read/write/execute permissions.";
}

$db->commit();

//TODO error handling

// Respond with the result of this operation
$product = new Product($pid);
echo $product->getJSON();
