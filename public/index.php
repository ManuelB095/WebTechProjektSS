<?php
require_once('../init.php');
?>
<!DOCTYPE html>
<html lang="de">

<?php
include("../pageparts/head.php");
?>

<body>
    <?php
    include("../pageparts/navBar.php");
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div id="flash_msg" class="col-12 alert" style="display: none;">
                <span id="flash_msg_icon" class="ui-icon"></span>
                <span id="flash_msg_text"></span>
            </div>
        </div>
        <div class="row justify-content-center">
            <main class="col-12">
            <?php
            $subpage = trim(filter_input(INPUT_GET, 'subpage', FILTER_SANITIZE_STRING));

            if(!empty( $subpage ) && file_exists( "../subpages/$subpage.php" ))
                { include( "../subpages/$subpage.php" ); }
            else
                { include( "../subpages/shop.php" ); }
            ?>
            </main>
        </div>
    </div>

<?php
if(empty( $_SESSION['username'] ))
{
?>
    <div id="dialog_register" title="Registrieren">
        <form method="post">
            <input id="register_username" name="username" type="text" required placeholder="Nutzername" />
            <input id="register_email" name="email" type="email" required placeholder="email@beispiel.de" />
            <input id="register_password" name="password" type="password" required placeholder="Passwort" />
            <input id="register_password_repeat" type="password" required placeholder="Passwort bestätigen" />
            <select id="register_salutation" name="title" required>
                <option value="">Keine Anrede</option>
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
            </select>
            <input id="register_firstname" name="firstname" type="text" required placeholder="Vorname" />
            <input id="register_lastname" name="lastname" type="text" required placeholder="Nachname" />
            <input id="register_address" name="address" type="text" required placeholder="Adresse" />
            <input id="register_town" name="location" type="text" required placeholder="Ortschaft" />
            <input id="register_postcode" name="plz" type="text" required placeholder="PLZ" />
            <!-- button id="btn_register" type="submit">Registrieren</button -->
        </form>
    </div>

    <div id="dialog_login" title="Anmelden">
        <form method="post">
            <input id="login_username" name="username" type="text" required placeholder="Nutzername" />
            <input id="login_password" name="password" type="password" required placeholder="Passwort" />
            <button id="btn_login" type="submit">Anmelden</button>
        </form>
    </div>
<?php
}
else
{
?>
    <div id="dialog_profile" title="Profil">
        <form method="post">
            <input id="profile_username" name="username" type="text" required placeholder="Nutzername" readonly />
            <input id="profile_email" name="email" type="email" placeholder="email@beispiel.de" />
            <input id="profile_password_new" name="password" type="password" placeholder="Neues Passwort" />
            <input id="profile_password_old" name="password_old" type="password" required placeholder="Altes Passwort bestätigen" />
            <select id="profile_salutation" name="title">
                <option value="">Keine Anrede</option>
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
            </select>
            <input id="profile_firstname" name="firstname" type="text" placeholder="Vorname" />
            <input id="profile_lastname" name="lastname" type="text" placeholder="Nachname" />
            <input id="profile_address" name="address" type="text" placeholder="Adresse" />
            <input id="profile_town" name="location" type="text" placeholder="Ortschaft" />
            <input id="profile_postcode" name="plz" type="text" placeholder="PLZ" />
            <!-- button id="btn_updateprofile" type="submit">Profil Ändern</button -->
        </form>
    </div>
<?php
}
?>
</body>
</html>
