"use strict";
//"use strict" applies important security measures,
//but also forces us to comply with declaration and such. -LG

/*
|------------------------------------------------
| Dialog Factory
|------------------------------------------------
|
| Since everything shall happen via AJAX (ugh),
| we may as well work with proper "windows".
|
| Luckily, JQuery UI has the perfect solution:
| Dialogs are draggable, resizable iframes.
| They have ARIA and keyboard controls built-in.
| The dialog content is entirely customisable.
|
*/

var dialogFactory = {
    imageDetails: function()
    {
        var dialog = $('<div>');
        dialog.prop('title','Image Name Here');

        var image = $('<img>');
        image.addClass('dialog-image');
        image.prop('src','ugc/full/4321/johanna-pferd.jpg');
        dialog.append(image);

        var prevBtn = $('<a>');
        prevBtn.addClass("dialog-prev");
        prevBtn.html('❮');
        prevBtn.on("click", prevSlide);
        dialog.append(prevBtn);

        var nextBtn = $('<a>');
        nextBtn.addClass("dialog-next");
        nextBtn.html('❯');
        nextBtn.on("click", nextSlide);
        dialog.append(nextBtn);
        
        dialog.dialog();
    },
};


/*
|------------------------------------------------
| Draggable Tags
|------------------------------------------------
*/

class SidebarTag
{ 
    static _LoadedTags = [];

    constructor(value, root)
    {
        //register this
        SidebarTag._LoadedTags.push(this);

        this._value = value;

        this.div = $("<div>");
        this.div.addClass("sidebar-tag");

        this.check = $("<input>");
        this.check.prop("type", "checkbox");
        this.check.on("click", function(e)
        {
            //TODO updateFilter(tagname);
        });
        this.div.append( this.check );

        this.draggable = $("<span>");
        this.draggable.addClass("sidebar-tag-draggable");
        this.draggable.draggable({
            revert: "invalid",
            helper: "clone"
        });
        this.draggable.html( this._value );
        this.div.append( this.draggable );

        if( root != null )
        {
            root.append(this.div);
        }
    }
}



/*
|------------------------------------------------
| Draggable Products
|------------------------------------------------
*/

class GalleryItem
{ 
    static _LoadedItems = [];

    constructor(productid, root)
    {
        //register this
        GalleryItem._LoadedItems.push(this);

        this._productid = productid; //.toString()

        this.div = $("<div>");
        this.div.addClass("gallery-item");
        this.div.droppable({
            accept: ".sidebar-tag-draggable",
            drop: function( event, ui ) {
                alert("GalleryItem.img received some kind of thing!");
            }
        });

        this.img = $("<img>");
        this.img.prop("src", "ugc/thumb/"+ this._productid +".jpg");
        this.img.on("click", function(e)
        {
            dialogFactory.imageDetails();
            //TODO updateFilter(tagname);
            //If owned or bought, show new Modal() with the full size version
        });
        this.img.draggable({
            revert: true
        });
        this.div.append( this.img );

        this.check = $("<input>");
        this.check.attr("type", "checkbox");
        this.div.append( this.check );

        //TODO badges for owned/bought/geodata
        //TODO draggable

        if( root != null )
        {
            root.append(this.div);
        }
    }

    static RemoveAll()
    {
        for(var i = GalleryItem._LoadedItems.length; i >= 0; --i)
        {
            //destroy DOM
            GalleryItem._LoadedItems[i].div.remove()
            //unregister this
            delete GalleryItem._LoadedItems[i];
        }
        GalleryItem._LoadedItems = [];
    }
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
        $("#filter_text").prop('value', '');
        $("#check_filter_owned").prop('checked', true);
        $("#check_filter_bought").prop('checked', true);
        $("#check_filter_buyable").prop('checked', true);
        //TODO update #gallery_list
    });

    /* dummies for UI tests */
    new SidebarTag( "Österreich", $('#taglist') );
    new SidebarTag( "Wien", $('#taglist') );
    new GalleryItem( "1234", $('#gallery_list') );
    new GalleryItem( "1234", $('#gallery_list') );
    new GalleryItem( "4321", $('#gallery_list') );
    new GalleryItem( "1234", $('#gallery_list') );

});
