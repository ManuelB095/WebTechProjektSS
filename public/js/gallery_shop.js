"use strict";
//"use strict" applies important security measures,
//but also forces us to comply with declaration and such. -LG

//This file currently declares and defines all classes
//it uses. Maybe we can split it up reasonably? Low priority. -LG

/*
|------------------------------------------------
| BasicModal
|------------------------------------------------
|
| Since everything shall happen via AJAX (ugh),
| we may as well work with proper "windows".
|
*/

class BasicModal
{
    static _OpenModals = [];

    constructor(root)
    {
        //register this
        BasicModal._OpenModals.push(this);

        //create DOM
        this.bg = $('<div>');
        this.bg.addClass("modal-bg");

        //Exit Button
        this.closeBtn = $('<span>');
        this.closeBtn.addClass("modal-close");
        this.closeBtn.html('&times;');
        this.closeBtn.on("click", this.Close.bind(this) );
        this.bg.append(this.closeBtn);

        //Populated by child classes
        this.contentDiv = $('<div>');
        this.contentDiv.addClass("modal-content");
        this.bg.append(this.contentDiv);

        if( root != null )
        {
            root.append(this.bg);
        }
    }

    Close()
    {
        //destroy DOM
        this.bg.remove();
        //Note that .remove() simply detaches the element from DOM, JS built-in garbage collector does the rest. (or at least I think so -LG)

        //unregister this
        for(var i = 0; i < BasicModal._OpenModals.length; ++i)
        {
            if( BasicModal._OpenModals[i] == this )
            {
                BasicModal._OpenModals.splice(0, i);
                delete this;
                return true;
            }
        }
    }

    static CloseAll()
    {
        for(var i = BasicModal._OpenModals.length; i >= 0; --i)
        {
            //destroy DOM
            BasicModal._OpenModals[i].bg.remove()
            //unregister this
            delete BasicModal._OpenModals[i];
        }
    }

    /*get var0()
    {
        return this._var0;
    }
    set var0(value)
    {
        this._var0 = value;
    }*/
}

/*
|------------------------------------------------
| RegisterModal
|------------------------------------------------
*/

class RegisterModal extends BasicModal
{
    constructor(root)
    {
        super(root); //invoke parent constructor

        //this.element.style.cursor = 'pointer';
    }
}

/*
|------------------------------------------------
| My Garbage Heap -LG
|------------------------------------------------
|
| I swear I will clean this up in a few days.
| (Whereas 'few' is a malleable term.)
|
*/

/* stuff from my original ue4 modal

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


sketches for some more classes

sidebar_tag: 
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


gallery_item:
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

*/



/*
|------------------------------------------------
| On Ready Callback
|------------------------------------------------
*/

jQuery(document).ready(function($)
{

    $("#btn_filter_reset").on("click", function(e)
    {
        $("#filter_text").prop('value', '');
        $("#check_filter_owned").prop('checked', true);
        $("#check_filter_bought").prop('checked', true);
        $("#check_filter_buyable").prop('checked', true);
        //TODO update
    });

    /* enable this to test the modal
    $("#btn_delete").on("click", function(e)
    {
        new BasicModal( $('body') )
    });
    */

});
