<?php
require_once('../init.php');
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title><?php echo Config('app','name'); ?></title>
    <meta name="description" content="Bitte kaufen Sie unsere legitim erworbenen Fotografien.">
    <meta name="keywords" content="FHTW, Technikum">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="js/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" type=text/css href="assets/BasicModal.css" />
    <link rel="shortcut icon" href="assets/fhtw-16x16.ico" >
</head>
<body>

    <nav>
        <a href="shop">Gallerie</a>
        <a href="help">Hilfe</a>
        <a href="rss">RSS Feed</a>
        <a href="admin">Administration</a>
        <?php
        if( TRUE ) {
        ?>
            <a><?php //TODO insert username, clickable for profile settings? ?></a>
            <a>Logout</a>
        <?php
        } else { //nicht angemeldet
        ?>
            <a>Registrieren</a>
            <a>Login</a>
        <?php } ?>
    </nav>

    <main>
        <?php
        $subpage = trim(filter_input(INPUT_GET, 'subpage', FILTER_SANITIZE_STRING));

        if(!empty( $subpage ) && file_exists( "../subpages/$subpage.php" ))
            { include( "../subpages/$subpage.php" ); }
        else
            { include( "../subpages/shop.php" ); }
        ?>
    </main>

</body>
</html>
