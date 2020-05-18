<h1>Gallerie</h1>
<button id="btn_delete"><span class="ui-icon ui-icon-trash"></span>Gewählte löschen</button>
<button id="btn_download"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span>Gewählte herunterladen</button>
<button id="btn_addcart"><span class="ui-icon ui-icon-cart"></span>Gewählte in Warenkorb</button>
<button id="btn_showcart"><span class="ui-icon ui-icon-newwin"></span>Zeige Warenkorb</button> <!-- JQuery UI has an icon class for a shopping cart symbol -->
<div id="gallery_root" class="gallery-root">
    <section id="gallery_list" class="gallery-list">
        <!-- populated by JS -->
    </section>
    <section id="gallery_sidebar">
        <button id="btn_filter_reset"><span class="ui-icon ui-icon-arrowreturn-1-w"></span>Filter leeren</button>
        <input id="filter_text" type="text" placeholder="Suchbegriff..." />
        <input id="check_filter_owned" type="checkbox" checked><label for="check_filter_owned">eigene</label></input>
        <input id="check_filter_bought" type="checkbox" checked><label for="check_filter_bought">erworbene</label></input>
        <input id="check_filter_buyable" type="checkbox" checked><label for="check_filter_buyable">kaufbare</label></input>
        <hr>
        <select id="select_order">
            <option value="new_first">Neueste zuerst</option>
            <option value="old_first">Älteste zuerst</option>
            <option value="most_bought">Beliebteste</option>
            <option value="user_asc">Nach Uploader (A-Z)</option>
            <option value="user_desc">Nach Uploader (Z-A)</option>
        </select>
        <hr>
        <button id="btn_tags_delete"><span class="ui-icon ui-icon-trash"></span>Gewählte Tags löschen</button>
        <input id="input_new_tag" type="text" placeholder="Neuer Tag..." />
        <button id="btn_tags_add"><span class="ui-icon ui-icon-plus"></span>Tag hinzufügen</button>
        <div id="taglist" class="sidebar-taglist">
            <!-- populated by JS -->
        </div>
    </section>
</div>

<div id="dialog_productdetails" title="Bild-Details">
    <img id="productdetails_img" class="dialog-image">
    <button id="productdetails_prev" class="dialog-prev ui-icon ui-icon-caret-1-w">
    <button id="productdetails_next" class="dialog-next ui-icon ui-icon-caret-1-e">
    <div id="productdetails_taglist">
        <!-- populated by JS -->
    </div>
    <p>Geodaten: € <span id="productdetails_geodata"></span></p>
    <button id="btn_productdetails_download">Herunterladen</button> <!--TODO-->
</div>
<div id="dialog_shopcart" title="Warenkorb">
    <div id="shopcart_list">
        <!-- populated by JS -->
    </div>
    <p>Gesamtpreis: € <span id="shopcart_total"></span></p>
    <p>Lieferadresse:<br><?php echo 'Mustergasse 14'; ?><br><?php echo '1010'; ?> <?php echo 'Wien'; //TODO use actual data ?></p>
</div>

<script src="js/model/product.js"></script>
<script src="js/model/tag.js"></script>
<script src="js/gallery_shop.js"></script>
