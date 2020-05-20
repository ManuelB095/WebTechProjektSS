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
    <script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" type=text/css href="js/jquery-ui-1.12.1/jquery-ui.min.css" />

    <link rel="stylesheet" type=text/css href="assets/BasicModal.css" />
    <link rel="stylesheet" type=text/css href="assets/CustomShop.css" />
    <link rel="shortcut icon" href="assets/fhtw-16x16.ico" >
    <script src="js/index.js"></script>
</head>
<body>

    <nav>
        <a href="shop">Galerie</a>
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

<!-- TODO perhaps exclude these if already logged in -->
    <div id="dialog_register" title="Registrieren">
        <form method="post">
            <input id="register_username" name="username" type="text" required placeholder="Nutzername" />
            <input id="register_email" name="email" type="email" required placeholder="email@beispiel.de" />
            <input id="register_password" name="password" type="password" required placeholder="Passwort" />
            <input id="register_password_repeat" type="password" required placeholder="Passwort bestätigen" />
            <select id="register_salutation" name="salutation" required>
                <option value="">Keine Anrede</option>
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
            </select>
            <input id="register_firstname" name="firstname" type="text" required placeholder="Vorname" />
            <input id="register_lastname" name="lastname" type="text" required placeholder="Nachname" />
            <input id="register_address" name="address" type="text" required placeholder="Adresse" />
            <input id="register_town" name="town" type="text" required placeholder="Ortschaft" />
            <input id="register_postcode" name="postcode" type="text" required placeholder="PLZ" />
            <button id="btn_register" type="submit">Registrieren</button>
        </form>
    </div>
    <div id="dialog_login" title="Anmelden">
        <form method="post">
            <input id="login_username" name="username" type="text" required placeholder="Nutzername" />
            <input id="login_password" name="password" type="password" required placeholder="Passwort" />
            <button id="btn_register" type="submit">Anmelden</button>
        </form>
    </div>

</body>
</html>
