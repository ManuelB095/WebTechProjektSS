"use strict";
//"use strict" applies important security measures,
//but also forces us to comply with declaration and such. -LG


/*
|------------------------------------------------
| Draggable Tags
|------------------------------------------------
*/

class SidebarTagView
{ 
    static _all = [];

    constructor(model)
    {
        //register this
        SidebarTagView._all.push(this);

        this._model = model;

        this.div = $("<div>");
        this.div.addClass("sidebar-tag");

        this.check = $("<input>");
        this.check.prop("type", "checkbox");
        this.check.on("click", this.onclick_check.bind(this));
        this.div.append( this.check );

        this.draggable = $("<span>");
        this.draggable.addClass("sidebar-tag-draggable");
        this.draggable.attr('tagid',this._model.value); //TODO can this be fancier? -LG
        this.draggable.draggable({
            revert: "invalid",
            helper: "clone"
        });
        this.draggable.html( this._model.value );
        this.div.append( this.draggable );

        $('#taglist').append(this.div);
    }

    onclick_check(e)
    {
        //TODO updateFilter(tagname);
    }

    static removeAll()
    {
        for(var i = this._all.length -1; i >= 0; --i)
        {
            //destroy DOM
            this._all[i].div.remove()
            //unregister this
            delete this._all[i];
        }
        this._all = [];
    }

}


/*
|------------------------------------------------
| Details Tags
|------------------------------------------------
*/

class DetailsTagView
{ 
    static _all = [];

    constructor(model)
    {
        //register this
        DetailsTagView._all.push(this);

        this._model = model;

        this.div = $('<div>');
        this.div.prop('tagid',this._tagid);
        this.div.html( this._model.value );
        this.div.on('click', this.onclick_div.bind(this));

        $('#productdetails_taglist').append(this.div);
    }

    onclick_div(e)
    {
        //TODO ask for confirmation somehow? Then tell models to disassociate from one another and remove this html
    }

    static removeAll()
    {
        for(var i = this._all.length -1; i >= 0; --i)
        {
            //destroy DOM
            this._all[i].div.remove()
            //unregister this
            delete this._all[i];
        }
        this._all = [];
    }

}


/*
|------------------------------------------------
| Draggable Products
|------------------------------------------------
*/

class GalleryProductView
{ 
    static _all = [];

    constructor(model)
    {
        //register this
        GalleryProductView._all.push(this);

        this._model = model;

        this.div = $("<div>");
        this.div.addClass("gallery-item");
        this.div.droppable({
            accept: ".sidebar-tag-draggable",
            drop: function( event, ui ) {
                //alert(ui.draggable.attr('tagid'));
                //TODO tell server to tag this product
            }
        });
        this.div.on('click', this.onclick_div.bind(this));

        this.img = $("<img>");
        this.img.prop('src', 'ugc/thumb/'+ this._model.pid +'.jpg');
        this.img.draggable({
            revert: true
        });
        this.div.append( this.img );

        if( this._model.access > 0 )
        {
            this.ownerbadge = $('<span>');
            this.ownerbadge.addClass('ui-icon');
            this.ownerbadge.addClass('ui-icon-person');
            if( this._model.access == 1 )
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

        if( this._model.pr_exif )
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

        $('#gallery_list').append(this.div);
    }

    setProductDetailsToThis()
    {
        $('#dialog_productdetails').attr('productid', this._model.pid);
        $('#productdetails_img').prop('src','ugc/full/'+ this._model.pid +'/'+this._model.pr_filename);
        DetailsTagView.removeAll();
        //TODO foreach model.tags do new DetailsTagView(tag)
        $('#productdetails_geodata').html('(171,64/92,08)'); //TODO use actual data
    }

    onclick_div(e)
    {
        //TODO this should not fire when clicking the checkbox
        //TODO should this only work if the current user has download permissions for the item? -LG
        this.setProductDetailsToThis();
        $('#dialog_productdetails').dialog('open');
    }

    static GetNextObject(id)
    {
        for(var i = this._all.length -2; i >= 0; --i)
        {
            if( this._all[i]._model.pid == id )
            {
                return this._all[++i];
            }
        }
        return this._all[0];
    }

    static GetPrevObject(id)
    {
        for(var i = this._all.length -1; i >= 1; --i)
        {
            if( this._all[i]._model.pid == id )
            {
                return this._all[--i];
            }
        }
        return this._all[ this._all.length -1 ];
    }

    static removeAll()
    {
        for(var i = this._all.length -1; i >= 0; --i)
        {
            //destroy DOM
            this._all[i].div.remove()
            //unregister this
            delete this._all[i];
        }
        this._all = [];
    }
}


/*
|------------------------------------------------
| Shopcarted Products
|------------------------------------------------
*/

class ShopcartProductView
{ 
    static _all = [];

    constructor(model)
    {
        //register this
        ShopcartProductView._all.push(this);

        this._model = model;

        this.div = $('<div>');

        this.img = $('<img>');
        this.img.addClass('img-fluid');
        this.img.prop('src', 'ugc/thumb/'+ this._model.pid +'.jpg');
        this.div.append(this.img);

        this.div.append('<span>€ 10,--</span>');

        this.btn_uncart = $('<button>');
        this.btn_uncart.html('<span class="ui-icon ui-icon-arrowreturn-1-w">Entfernen');
        this.btn_uncart.on('click', this.onclick_uncart.bind(this));
        this.div.append(this.btn_uncart);

        $('#shopcart_list').append(this.div);
    }

    onclick_uncart(e)
    {
        //TODO tell server to uncart this, refresh based on response (and maybe give subtle success confirmation, e.g. fadeout using JQuery UI)
    }

    static removeAll()
    {
        for(var i = this._all.length -1; i >= 0; --i)
        {
            //destroy DOM
            this._all[i].div.remove()
            //unregister this
            delete this._all[i];
        }
        this._all = [];
    }
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


    $('#productdetails_prev').on('click', function(e)
    {
        GalleryProductView
            .GetPrevObject($('#dialog_productdetails').attr('productid'))
                .setProductDetailsToThis();
    });
    $('#productdetails_next').on('click', function(e)
    {
        GalleryProductView
            .GetNextObject($('#dialog_productdetails').attr('productid'))
                .setProductDetailsToThis();
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

    /*
    |------------------------------------------------
    | File Upload via Drag-n-Drop
    |------------------------------------------------
    */

    $('.upload-area').on({
        dragover: function(e)
        {
            e.preventDefault(); // Bitte die Datei nicht im Browser öffnen
            $(this).addClass('drag-target');
        },
        dragleave: function(e)
        {
            $(this).removeClass('drag-target');
        },
        drop: function(e)
        {
            // Nochmal: Bitte die Datei nicht im Browser öffnen
            e.stopPropagation();
            e.preventDefault();

            $(this).removeClass('drag-target');

            var regex_filetypes = /.*\.(jpg|jpeg|png|gif|bmp|webp)$/i;
            // We could also pre-check magic number via FileReader, but we're not getting paid. :)

            for (var i = 0; i < e.originalEvent.dataTransfer.files.length; ++i)
            {
                if(regex_filetypes.test(e.originalEvent.dataTransfer.files[i].name))
                {
                    let fd = new FormData();
                    fd.append('productfile', e.originalEvent.dataTransfer.files[i] );
                    fd.append('action', 'createproduct');
                    $.ajax({
                        url: 'actions.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        cache: false,
                        dataType: 'json',
                        success: function(response)
                        {
                            new GalleryProductView(response);
                        },
                        error: function(jqxhr, status, exception)
                        {
                            alert(exception);
                        },
                    })
                }
            }
        },
    })

    /*
    |------------------------------------------------
    | Population
    |------------------------------------------------
    */

    var fd = new FormData();
    fd.append('action', 'indexproduct');
    $.ajax({
        url: 'actions.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        dataType: 'json',
        success: function(response)
        {
            for(var i = 0; i < response.length; ++i)
            {
                var fd = new FormData();
                fd.append('action', 'getproduct');
                fd.append('pid', response[i]);
                $.ajax({
                    url: 'actions.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: 'json',
                    success: function(response)
                    {
                        //new ShopcartProductView(response);
                        new GalleryProductView(response);
                    },
                    error: function(jqxhr, status, exception)
                    {
                        alert(exception);
                    },
                });
            }
        },
        error: function(jqxhr, status, exception)
        {
            alert(exception);
        },
    });


    /* dummies for UI tests */
    new SidebarTagView( {'id':1,'value':'Österreich'} );
    new SidebarTagView( {'id':2,'value':'Wien'} );
    new SidebarTagView( {'id':3,'value':'Semmering'} );

});
