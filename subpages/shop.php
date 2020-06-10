<h1>Galerie</h1>
<?php
// only if logged in
if(!empty( $_SESSION['username'] ))
{
?>
<button id="btn_delete"><span class="ui-icon ui-icon-trash"></span>Gewählte löschen</button>
<button id="btn_download"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span>Gewählte herunterladen</button>
<button id="btn_addcart"><span class="ui-icon ui-icon-cart"></span>Gewählte in Warenkorb</button>
<button id="btn_showcart"><span class="ui-icon ui-icon-newwin"></span>Zeige Warenkorb</button>
<?php
}
?>
<div id="gallery_root" class="gallery-root row justify-content-center">
    <section id="gallery_list" class="col-md-8 col-sm-7 col-6 gallery-list <?php if(!empty( $_SESSION['username'] )) echo "upload-area"; ?>">
        <!-- populated by JS -->
    </section>
    <section id="gallery_sidebar" class="col-md-4 col-sm-5 col-6">
        <button id="btn_filter_reset"><span class="ui-icon ui-icon-arrowreturn-1-w"></span>Filter leeren</button>
        <input id="filter_text" type="text" placeholder="Suchbegriff..." />
        <div>
            <input id="check_filter_owned" type="checkbox" checked></input>
            <label for="check_filter_owned" class="form-check-label">eigene</label>
        </div>
        <div>
            <input id="check_filter_bought" type="checkbox" checked></input>
            <label for="check_filter_bought" class="form-check-label">erworbene</label>
        </div>
        <div>
            <input id="check_filter_buyable" type="checkbox" checked></input>
            <label for="check_filter_buyable" class="form-check-label">kaufbare</label>
        </div>
        <hr>
        <select id="select_order">
            <option value="new_first">Neueste zuerst</option>
            <option value="old_first">Älteste zuerst</option>
            <option value="most_bought">Beliebteste</option>
            <option value="user_asc">Nach Uploader (A-Z)</option>
            <option value="user_desc">Nach Uploader (Z-A)</option>
        </select>
        <hr>
<?php
// only if logged in
if(!empty( $_SESSION['username'] ))
{
?>
        <button id="btn_tags_delete"><span class="ui-icon ui-icon-trash"></span>Gewählte Tags löschen</button>
        <input id="input_new_tag" type="text" placeholder="Neuer Tag..." />
        <button id="btn_tags_add"><span class="ui-icon ui-icon-plus"></span>Tag hinzufügen</button>
<?php
}
?>
        <div id="taglist" class="sidebar-taglist">
            <!-- populated by JS -->
        </div>
    </section>
</div>

<div id="dialog_productdetails" title="Bild-Details">
    <img id="productdetails_img" class="img-fluid">
    <button id="productdetails_prev" class="dialog-prev ui-icon ui-icon-caret-1-w"></button>
    <button id="productdetails_next" class="dialog-next ui-icon ui-icon-caret-1-e"></button>
    <div id="productdetails_taglist">
        <!-- populated by JS -->
    </div>
    <p>Geodaten: € <span id="productdetails_geodata"></span></p>
    <button id="btn_productdetails_download">Herunterladen</button> <!--TODO-->
</div>
<?php
// only if logged in
if(!empty( $_SESSION['username'] ))
{
?>
<div id="dialog_shopcart" title="Warenkorb">
    <div id="shopcart_list">
        <!-- populated by JS -->
    </div>
    <p>Gesamtpreis: € <span id="shopcart_total"></span></p>
    <p>Lieferadresse:<br><?php echo $_SESSION['address']; ?><br><?php echo $_SESSION['plz']; ?> <?php echo $_SESSION['location']; ?></p>
</div>
<?php
}
?>

<script src="js/gallery_shop.js"></script>
