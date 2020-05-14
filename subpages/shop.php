<h1>Gallerie</h1>
<button id="btn_delete">Gewählte löschen</button>
<button id="btn_download">Gewählte herunterladen</button>
<button id="btn_addcart">Gewählte in Warenkorb</button>
<button id="btn_showcart">Zeige Warenkorb</button> <!-- JQuery UI has an icon class for a shopping cart symbol -->
<div id="gallery_root" class="gallery-root">
    <section id="gallery_list" class="gallery-list">
        <!-- populated by JS -->
    </section>
    <section id="gallery_sidebar">
        <button id="btn_filter_reset">Filter leeren</button>
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
        <button id="btn_tags_delete">Gewählte Tags löschen</button>
        <input id="input_new_tag" type="text" placeholder="Neuer Tag..." />
        <button id="btn_tags_add">Tag hinzufügen</button>
        <div id="taglist">
            <!-- populated by JS -->
        </div>
    </section>
</div>
<script src="js/gallery_shop.js"></script>
