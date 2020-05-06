<h1>Gallerie</h1>
<!-- much of this is populated by JS -->
<!--TODO shopcart-->
<button id="btn_delete">Ausgewählte löschen</button>
<button id="btn_download">Ausgewählte herunterladen</button>
<button id="btn_cart">Ausgewählte in Warenkorb</button>
<section id="gallery_list" />
<section id="gallery_sidebar">
    <button id="btn_filter_reset">Filter leeren</button>
    <input id="filter_text" type="text" placeholder="Suchbegriff..." />
    <input id="check_filter_owned" type="checkbox"><label for="check_filter_owned">eigene</label></input>
    <input id="check_filter_bought" type="checkbox"><label for="check_filter_bought">erworbene</label></input>
    <input id="check_filter_buyable" type="checkbox"><label for="check_filter_buyable">kaufbare</label></input>
    <div class="horizontal_line">
    <select id="select_order">
        <option value="new_first">Neueste zuerst</option>
        <option value="old_first">Älteste zuerst</option>
        <option value="most_bought">Beliebteste</option>
        <option value="user_asc">Nach Uploader (A-Z)</option>
        <option value="user_desc">Nach Uploader (Z-A)</option>
    </select>
    <div class="horizontal_line">
    <div id="taglist" />
</section>
<script src="js/gallery_shop.js"></script>
