//This file is a mess haha

/*
|------------------------------------------------
| Factory
|------------------------------------------------
|
| The factory may be used to produce "objects"
| using the defined assembler functions.
| It's basically classes except only exists in
| the DOM and not JS, meaning less potential for
| discrepancies between JS and DOM.
|
*/

factory = {
    sidebar_tag: function(tagname)
    {
        var div = $("<div>");

        //TODO var draggable = $("<div>");
        // div.append(draggable);

        var check = $("<input>");
        check.attr("type", "checkbox");
        check.on("click", function(e)
        {
            //TODO updateFilter(tagname);
        });
        div.append(check);

        return div;
    },
    gallery_item: function(productid)
    {
        var div = $("<div>");

        var img = $("<img>");
        img.attr("src", "ugc/12345.jpg");
        img.on("click", function(e)
        {
            //TODO updateFilter(tagname);
        });
        div.append(img);

        var check = $("<input>");
        check.attr("type", "checkbox");
        div.append(check);

        //TODO badges for owned/bought/geodata
        //TODO draggable

        return div;
    },

    /*
    |------------------------------------------------
    | Modals
    |------------------------------------------------
    |
    | Since everything shall happen via AJAX (ugh),
    | we may as well work with proper "windows".
    |
    */

    basic_modal: function(contentDiv)
    {
        var modal = $('<div id="modal"/>');
        modal.addClass("modal");

        //Exit Button
        var closeBtn = $('<span/>');
        closeBtn.addClass("modal-close");
        closeBtn.html('&times;');
        closeBtn.on("click", closeModal);
        modal.append(closeBtn);

        //var contentDiv = $('<div/>');
        if( contentDiv != null )
        {
            contentDiv.addClass("modal-content");
            modal.append(contentDiv);
        }

/*
        //Big Picture
        var slideDiv = $('<div/>');
        slideDiv.append('<div id="lightboxnum" class="numbertext"/>');
        slideDiv.append('<img id="lightboximg" class="modal-bigimg">');
        contentDiv.append(slideDiv);

        //Slideshow Buttons
        var prevBtn = $('<a/>');
        prevBtn.addClass("modal-prev");
        prevBtn.html('❮');
        prevBtn.on("click", prevSlide);
        contentDiv.append(prevBtn);

        var nextBtn = $('<a/>');
        nextBtn.addClass("modal-next");
        nextBtn.html('❯');
        nextBtn.on("click", nextSlide);
        contentDiv.append(nextBtn);

        //Caption
        contentDiv.append('<div class="caption-container"><p id="caption"/></div>');
*/

        return modal;
    },
}



/*
|------------------------------------------------
| On Ready Callback
|------------------------------------------------
*/

jQuery(document).ready(function($)
{

    $("#btn_filter_reset").on("click", function(e)
    {
        $("#filter_text").value = '';
        $("#check_filter_owned").checked = true;
        $("#check_filter_bought").checked = true;
        $("#check_filter_buyable").checked = true;
        //TODO update
    });


});
