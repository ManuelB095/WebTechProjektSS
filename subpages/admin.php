<h1>Administration</h1>
<?php
// only if logged in
if(!empty( $_SESSION['is_admin'] ))
{
?>
<div id="userlist"></div>

<div id="dialog_profileadmin" title="Profil (Sudo)">
    <form method="post">
        <input id="profileadmin_username" name="username" type="text" required placeholder="Nutzername" readonly />
        <input id="profileadmin_email" name="email" type="email" placeholder="email@beispiel.de" />
        <select id="profileadmin_salutation" name="title">
            <option value="">Keine Anrede</option>
            <option value="Herr">Herr</option>
            <option value="Frau">Frau</option>
        </select>
        <input id="profileadmin_firstname" name="firstname" type="text" placeholder="Vorname" />
        <input id="profileadmin_lastname" name="lastname" type="text" placeholder="Nachname" />
        <input id="profileadmin_address" name="address" type="text" placeholder="Adresse" />
        <input id="profileadmin_town" name="location" type="text" placeholder="Ortschaft" />
        <input id="profileadmin_postcode" name="plz" type="text" placeholder="PLZ" />
        <label for="profileadmin_isactive">Aktiv <input id="profileadmin_isactive" name="is_active" type="checkbox" /></label>
        <!-- button id="btn_updateprofile" type="submit">Profil Ändern</button -->
    </form>
</div>

<div id="dialog_listpurchases" title="Käufe">
    <table id="listpurchases">
    </table>
</div>

<script src="js/admin.js"></script>
<?php } ?>
