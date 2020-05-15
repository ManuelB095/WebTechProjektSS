"use strict";
//"use strict" applies important security measures,
//but also forces us to comply with declaration and such. -LG


/*
|------------------------------------------------
| Draggable Tags
|------------------------------------------------
*/

class SidebarTag
{ 
    static _LoadedTags = [];

    constructor(tagid, value, root)
    {
        //register this
        SidebarTag._LoadedTags.push(this);

        this._tagid = tagid;
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
        this.draggable.prop('tagid',this._tagid);
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

    getvalue()
    {
        return this._value;
    }

    static GetObjectByID(tagid)
    {
        for(var i = SidebarTag._LoadedTags.length; i >= 0; --i)
        {
            if( SidebarTag._LoadedTags[i].id == tagid )
            {
                return SidebarTag._LoadedTags[i];
            }
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

    constructor(productid, ownership, geodata, root)
    {
        //register this
        GalleryItem._LoadedItems.push(this);

        this._productid = productid; //.toString()

        this.div = $("<div>");
        this.div.addClass("gallery-item");
        this.div.droppable({
            accept: ".sidebar-tag-draggable",
            drop: function( event, ui ) {
                //alert("GalleryItem.img received "+ ui.draggable);
                //alert(ui.draggable.prop('tagid'));
                //TODO tell server to tag this product
            }
        });
        this.div.on("click", function(e)
        {
            //TODO this should not fire when clicking the checkbox
            //dialogFactory.imageDetails(this._productid);
            $('#dialog_productdetails').dialog('open');
        });

        this.img = $("<img>");
        this.img.prop("src", "ugc/thumb/"+ this._productid +".jpg");
        this.img.draggable({
            revert: true
        });
        this.div.append( this.img );

        if( ownership > 0 )
        {
            this.ownerbadge = $('<span>');
            this.ownerbadge.addClass('ui-icon');
            this.ownerbadge.addClass('ui-icon-person');
            if( ownership == 1 )
            {
                this.ownerbadge.addClass('badge-bg-yellow');
                this.ownerbadge.prop('title','erworben');
            }
            else
            {
                this.ownerbadge.addClass('badge-bg-green');
                this.ownerbadge.prop('title','eigenes');
            }
            this.div.append( this.ownerbadge );
        }

        if( geodata )
        {
            this.geobadge = $('<span>');
            this.geobadge.addClass('ui-icon');
            this.geobadge.addClass('ui-icon-pin-s');
            this.geobadge.addClass('badge-bg-yellow');
            this.geobadge.prop('title','Geodaten verfügbar');
            this.div.append( this.geobadge );
        }

        this.check = $("<input>");
        this.check.prop("type", "checkbox");
        this.div.append( this.check );

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
| List Stuff
|------------------------------------------------
*/

function addProductToCart(productid)
{
    var cartitem = $('<div>');

    var thumb = $('<img>');
    thumb.addClass('img-fluid');
    thumb.prop("src", "ugc/thumb/"+ productid +".jpg");
    cartitem.append(thumb);

    cartitem.append('<span>€ 10,--</span>');

    var btn_uncart = $('<button>');
    btn_uncart.html('<span class="ui-icon ui-icon-arrowreturn-1-w">Entfernen');
    btn_uncart.on('click', function()
    {
        //TODO tell server to uncart this, refresh based on response (and maybe give subtle success confirmation, e.g. fadeout using JQuery UI)
    });
    cartitem.append(btn_uncart);

    $('#shopcart_list').append(cartitem);
}


/*
|------------------------------------------------
| On Ready Callback
|------------------------------------------------
*/

jQuery(document).ready(function($)
{
    
    /*
    |------------------------------------------------
    | Configure Dialogs
    |------------------------------------------------
    */

    $('#dialog_shopcart').dialog({
        autoOpen: false,
        //modal: true,
        buttons: {
            'Bestellen': function() {
                //TODO this should close the dialog and tell the server to checkout, then refresh affected items in the main list based on response
            },
            //'Leeren': ,
        },
    });

    $('#dialog_productdetails').dialog({
        autoOpen: false,
        //modal: true,
    });


    $("#btn_filter_reset").on("click", function(e)
    {
        $("#filter_text").prop('value', '');
        $("#check_filter_owned").prop('checked', true);
        $("#check_filter_bought").prop('checked', true);
        $("#check_filter_buyable").prop('checked', true);
        //TODO update #gallery_list
    });

    $('#btn_delete').on('click', function(e)
    {
        //TODO send delete requests to server via AJAX, remove based on response (or simply refresh all), give clear success message (including number of actually deleted items?)
    });

    $('#btn_download').on('click', function(e)
    {
        //TODO no idea how to do this one elegantly, or at all -LG
    });

    $('#btn_addcart').on('click', function(e)
    {
        //TODO tell server to add these to the cart, give clear success message (including number of actually added items?), update #shopcart_list if it exists
    });

    $('#btn_showcart').on('click', function(e)
    {
        $('#dialog_shopcart').dialog('open');
    });

    $('#btn_tags_add').on('click', function(e)
    {
        //TODO tell server to check if #input_new_tag is unique and add it, give clear success/failure message
    });

    $('#btn_tags_delete').on('click', function(e)
    {
        //TODO tell server to delete checked tags, remove based on response (or simply refresh all), give clear success message (including number of actually deleted tags?)
    });


    /* dummies for UI tests */
    new SidebarTag( 0, "Österreich", $('#taglist') );
    new SidebarTag( 1, "Wien", $('#taglist') );
    new SidebarTag( 2, "Semmering", $('#taglist') );
    new GalleryItem( "1234", 1, true, $('#gallery_list') );
    new GalleryItem( "1234", 2, false, $('#gallery_list') );
    new GalleryItem( "4321", 1, false, $('#gallery_list') );
    new GalleryItem( "1234", 0, true, $('#gallery_list') );
    addProductToCart("1234");
    addProductToCart("4321");

});
