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
        this.draggable.attr('tagid',this._model.tid); //TODO can this be fancier? -LG
        this.draggable.draggable({
            revert: "invalid",
            helper: "clone"
        });
        this.draggable.html( this._model.t_name );
        this.div.append( this.draggable );

        $('#taglist').append(this.div);
    }

    onclick_check(e)
    {
        //TODO updateFilter(tagname);
    }

    static removeAll()
    {
        for(let i = this._all.length -1; i >= 0; --i)
        {
            //destroy DOM
            this._all[i].div.remove()
            //unregister this
            delete this._all[i];
        }
        this._all = [];
    }

    static remove(tid)
    {
        for(let i = this._all.length -1; i >= 0; --i)
        {
            if( this._all[i]._model.tid == tid )
            {
                //destroy DOM
                this._all[i].div.remove()
                //unregister this
                delete this._all[i];
                this._all.splice(i, 1);

                return true;
            }
        }
    }

    static getAllCheckedID()
    {
        let checked = [];
        for(let i = 0; i < this._all.length; ++i)
        {
            if( this._all[i].check.prop('checked') )
            {
                checked.push( this._all[i]._model.tid );
            }
        }
        return checked;
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
        this.div.html( this._model.t_name );
        this.div.on('click', this.onclick_div.bind(this));

        $('#productdetails_taglist').append(this.div);
    }

    onclick_div(e)
    {
        if( confirm("Wollen Sie diesen Tag entfernen?") )
        {
            // tell models to disassociate from one another and remove this html
            AjaxActionAndFlash({
                'action':'deleteproducttag',
                'pid':$('#dialog_productdetails').attr('productid'),
                'tid':this._model.tid,
            },  function(response)
                {
                    FlashSuccess("Tag von Bild enfernt.");
                    //TODO remove this
                    //TODO is there a clientside copy of the relation that
                }
            );
        }
    }

    static removeAll()
    {
        for(let i = this._all.length -1; i >= 0; --i)
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
            drop: this.ondropreceive_div.bind(this),
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
        //TODO should the clientside models already have relation info or should we fetch it anew here?
        $('#productdetails_geodata').html('(171,64/92,08)'); //TODO use actual data
    }

    onclick_div(e)
    {
        //TODO this should not fire when clicking the checkbox
        //TODO should this only work if the current user has download permissions for the item? -LG
        this.setProductDetailsToThis();
        $('#dialog_productdetails').dialog('open');
    }

    ondropreceive_div( e, ui )
    {
        // tell server to tag this product
        AjaxActionAndFlash({
            'action':'createproducttag',
            'tid':ui.draggable.attr('tagid'),
            'pid':this._model.pid,
        },  function(response)
            {
                FlashSuccess("Bild getagged!");
            }
        );
    }

    static GetNextObject(id)
    {
        for(let i = this._all.length -2; i >= 0; --i)
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
        for(let i = this._all.length -1; i >= 1; --i)
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
        for(let i = this._all.length -1; i >= 0; --i)
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
        for(let i = this._all.length -1; i >= 0; --i)
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
        // tell server to check if #input_new_tag is unique and add it
        AjaxActionAndFlash({
            'action':'createtag',
            't_name':$('#input_new_tag').val(),
        },  function(response)
            {
                FlashSuccess("Tag \""+ response.t_name +"\" erfolgreich hinzugefügt!");
                new SidebarTagView(response);
                $('#input_new_tag').val("");
            }
        );
    });

    $('#btn_tags_delete').on('click', function(e)
    {
        // tell server to delete checked tags, remove based on response (or simply refresh all), give clear success message (including number of actually deleted tags?)
        let targets = SidebarTagView.getAllCheckedID();
        AjaxActionAndFlash({
            'action':'deletetag',
            'tid':JSON.stringify(targets),
        },  function(response)
            {
                // notification
                if( response.length == 0 )
                {
                    FlashSuccess( targets.length +" Tags erfolgreich gelöscht." );
                }
                else if( response.length < targets.length )
                {
                    FlashWarning( response.length +" Tags konnten nicht gelöscht werden:<br>"+ response.join("<br>") );
                }
                else
                {
                    FlashError( "Die Tags konnten nicht gelöscht werden:<br>"+ response.join("<br>") );
                }
                // remove SidebarTagViews
                for(let i = 0; i < targets.length; ++i)
                {
                    if( !response[i] )
                    {
                        SidebarTagView.remove(targets[i])
                    }
                }
            }
        );
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

            let regex_filetypes = /.*\.(jpg|jpeg|png|gif|bmp|webp)$/i;
            // We could also pre-check magic number via FileReader, but we're not getting paid. :)

            for (let i = 0; i < e.originalEvent.dataTransfer.files.length; ++i)
            {
                if(regex_filetypes.test(e.originalEvent.dataTransfer.files[i].name))
                {
                    AjaxActionAndFlash({
                        'action':'createproduct',
                        'productfile':e.originalEvent.dataTransfer.files[i]
                    },  function(response)
                        {
                            new GalleryProductView(response);
                        }
                    );
                }
            }
        },
    })

    /*
    |------------------------------------------------
    | Population
    |------------------------------------------------
    */

    let fd = new FormData();
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
            for(let i = 0; i < response.length; ++i)
            {
                let fd = new FormData();
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
                        console.log(exception);
                        console.log(jqxhr);
                    },
                });
            }
        },
        error: function(jqxhr, status, exception)
        {
            console.log(exception);
            console.log(jqxhr);
        },
    });

    fd = new FormData();
    fd.append('action', 'indextag');
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
            for(let i = 0; i < response.length; ++i)
            {
                let fd = new FormData();
                fd.append('action', 'gettag');
                fd.append('tid', response[i]);
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
                        new SidebarTagView(response);
                    },
                    error: function(jqxhr, status, exception)
                    {
                        console.log(exception);
                        console.log(jqxhr);
                    },
                });
            }
        },
        error: function(jqxhr, status, exception)
        {
            console.log(exception);
            console.log(jqxhr);
        },
    });

});
