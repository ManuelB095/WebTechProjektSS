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
        GalleryProductView.updateFilter();
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

    static uncheckAll()
    {
        for(let i = 0; i < this._all.length; ++i)
        {
            this._all[i].check.prop('checked', false);
        }
    }

    static GetModelByID( tid )
    {
        for(let i = this._all.length -1; i >= 0; --i)
        {
            if( this._all[i]._model.tid == tid )
            {
                return this._all[i]._model;
            }
        }
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

        this.div = $('<span>');
        this.div.addClass('details-tag');
        this.div.html( this._model.t_name );
        this.div.on('click', this.onclick_div.bind(this));

        $('#productdetails_taglist').append(this.div);
    }

    onclick_div(e)
    {
        if( confirm("Wollen Sie diesen Tag entfernen?") )
        {
            // tell models to disassociate from one another and remove this html
            let pid = $('#dialog_productdetails').attr('productid');
            let tid = this._model.tid
            AjaxActionAndFlash({
                'action':'deleteproducttag',
                'pid':pid,
                'tid':tid,
            },  function(response)
                {
                    FlashSuccess("Tag von Bild enfernt.");
                    DetailsTagView.remove(tid);
                    // remove clientside copy of the relation from product model
                    GalleryProductView.removeTag( pid, tid );
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
        this.img.prop('alt', this._model.pid);
        this.img.addClass('gallery-product-draggable');
        this.img.draggable({
            revert: true,
        });
        this.img.attr('pid',this._model.pid); //TODO can this be fancier? -LG
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
        this.check.on('click', function(e) {
            e.stopPropagation();
        });
        this.div.append( this.check );

        $('#gallery_list').append(this.div);
    }

    setProductDetailsToThis()
    {
        $('#dialog_productdetails').attr('productid', this._model.pid);
        $('#productdetails_img').prop('src','ugc/full/'+ this._model.pid +'/'+this._model.pr_filename);
        $('#productdetails_geodata').html(this._model.pr_exif);
        $('#productdetails_date').html(this._model.pr_upload_date);
        $('#productdetails_owner').html(this._model.pr_owner);

        DetailsTagView.removeAll();
        // foreach model.tags do new DetailsTagView(tag)
        for(let i = this._model.tags.length -1; i >= 0; --i)
        {
            let tmodel = SidebarTagView.GetModelByID( this._model.tags[i] );
            new DetailsTagView( tmodel );
        }
    }

    onclick_div(e)
    {
        // This should only work if the current user has permissions for the item. -LG
        if( this._model.access < 1 ) { return; }

        this.setProductDetailsToThis();
        $('#dialog_productdetails').dialog('open');
    }

    ondropreceive_div( e, ui )
    {
        // tell server to tag this product
        let model = this._model;
        AjaxActionAndFlash({
            'action':'createproducttag',
            'tid':ui.draggable.attr('tagid'),
            'pid':model.pid,
        },  function(response)
            {
                FlashSuccess("Bild getagged!");
                model.tags.push( ui.draggable.attr('tagid') );
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

    static remove(pid)
    {
        for(let i = this._all.length -1; i >= 0; --i)
        {
            if( this._all[i]._model.pid == pid )
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

    static CopyToShopcart(pid)
    {
        for(let i = this._all.length -1; i >= 0; --i)
        {
            if( this._all[i]._model.pid == pid )
            {
                new ShopcartProductView( this._all[i]._model );
                return true;
            }
        }
    }

    static SetBought(pid)
    {
        for(let i = this._all.length -1; i >= 0; --i)
        {
            if( this._all[i]._model.pid == pid )
            {
                if( this._model.access == 0 )
                {
                    this._model.access = 1

                    this.ownerbadge = $('<span>');
                    this.ownerbadge.addClass('ui-icon');
                    this.ownerbadge.addClass('ui-icon-person');
                    this.ownerbadge.addClass('badge-bg-yellow');
                    this.ownerbadge.prop('title','erworben');

                    this.img.after( this.ownerbadge );
                }

                return true;
            }
        }
    }

    static removeTag(pid, tid)
    {
        for(let i = this._all.length -1; i >= 0; --i)
        {
            let model = this._all[i]._model;
            if( model.pid == pid )
            {
                for(let j = model.tags.length -1; j >= 0; --j)
                {
                    if( model.tags[j] == tid )
                    {
                        model.tags.splice(j, 1);
                        return true;
                    }
                }
                return false;
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
                checked.push( this._all[i]._model.pid );
            }
        }
        return checked;
    }

    static updateFilter()
    {
        let wantedtags = SidebarTagView.getAllCheckedID();
        let wantedowned = $('#check_filter_owned').prop('checked');
        let wantedbought = $('#check_filter_bought').prop('checked');
        let wantedbuyable = $('#check_filter_buyable').prop('checked');
        let all = GalleryProductView._all;

        for(let i = 0; i < all.length; ++i)
        {
            let tagsmatch = true;
            if( wantedtags.length > 0 )
            {
                for(let j = 0; j < wantedtags.length; ++j)
                {
                    if( all[i]._model.tags.indexOf(wantedtags[j]) == -1 )
                    {
                        tagsmatch = false;
                        break;
                    }
                }
            }

            if( tagsmatch
                && ( (all[i]._model.access == 0 && wantedbuyable) 
                  || (all[i]._model.access == 1 && wantedbought) 
                  || (all[i]._model.access == 2 && wantedowned) ))
            {
                all[i].div.show();
            }
            else
            {
                all[i].div.hide();
            }
        }
    }

    static orders = {
        // return < 0 means a comes first, > 0 means b comes first
        'new_first': function(a, b)
        {
            // Technically, we should use pr_upload_date, but the pid is an auto-incrementing ID, so naturally newer entries have higher pid. -LG
            return b._model.pid - a._model.pid;
        },
        'old_first': function(a, b)
        {
            return a._model.pid - b._model.pid;
        },
        'user_asc': function(a, b)
        {
            // In order to get a consistent sort order, we need to sneak a secondary order in. -LG
            let byname = a._model.pr_owner.localeCompare(b._model.pr_owner);
            return byname == 0 ? b._model.pid - a._model.pid : byname;
        },
        'user_desc': function(a, b)
        {
            let byname = b._model.pr_owner.localeCompare(a._model.pr_owner);
            return byname == 0 ? b._model.pid - a._model.pid : byname;
        },
    }

    static updateOrder( order )
    {
        if( this.orders[order] )
        {
            this._all.sort( this.orders[order] );
        }
        else
        {
            this._all.sort( this.orders.new_first );
        }

        for(let i = 0; i < this._all.length; ++i)
        {
            $('#gallery_list').append( this._all[i].div );
        }
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
        this.div.addClass('shopcart-item');

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
        $('#shopcart_total').html( (ShopcartProductView._all.length * 10).toString() +',--');
    }

    onclick_uncart(e)
    {
        // tell server to uncart this, refresh based on response (and maybe give subtle success confirmation, e.g. fadeout using JQuery UI)
        AjaxActionAndFlash({
            'action':'deleteshopcart',
            'pid':this._model.pid,
        }, this.remove.bind(this) );
    }

    removeFade()
    {
        this.div.hide( 'blind', {}, 300, this.remove.bind(this) );
    }

    remove()
    {
        for(let i = ShopcartProductView._all.length -1; i >= 0; --i)
        {
            //destroy DOM
            this.div.remove()
            //unregister this
            ShopcartProductView._all.splice(i, 1);
            $('#shopcart_total').html( (ShopcartProductView._all.length * 10).toString() +',--');
            delete this;
            return true;
        }
    }

    static remove(pid)
    {
        for(let i = this._all.length -1; i >= 0; --i)
        {
            if( this._all[i]._model.pid == pid )
            {
                //destroy DOM
                this._all[i].div.remove()
                //unregister this
                delete this._all[i];
                this._all.splice(i, 1);
                $('#shopcart_total').html( (ShopcartProductView._all.length * 10).toString() +',--');

                return true;
            }
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
        $('#shopcart_total').html('0,--');
    }

    static GetIDs()
    {
        let ids = [];
        for(let i = this._all.length -1; i >= 0; --i)
        {
            ids.push( this._all[i]._model.pid );
        }
        return ids;
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
                // this should close the dialog and tell the server to checkout, then refresh affected items in the main list based on response
                $('#dialog_shopcart').dialog('close');
                AjaxActionAndFlash({
                    'action':'checkout',
                },  function(response)
                    {
                        let targets = ShopcartProductView.GetIDs();
                        // notification
                        if( response.length == 0 )
                        {
                            FlashSuccess( targets.length +" Bilder erfolgreich bestellt." );
                        }
                        else if( response.length < targets.length )
                        {
                            FlashWarning( response.length +" Bilder konnten nicht bestellt werden:<br>"+ response.join("<br>") );
                        }
                        else
                        {
                            FlashError( "Die Bilder konnten nicht bestellt werden:<br>"+ response.join("<br>") );
                        }
                        // refresh main list (badges in particular)
                        // clear shopcart (of purchased products only?)
                        for(let i = 0; i < targets.length; ++i)
                        {
                            if( !response[i] )
                            {
                                GalleryProductView.SetBought( targets[i] );
                            }
                            ShopcartProductView.remove( targets[i] );
                        }
                    }
                );
            },
            //'Leeren': ,
        },
    });

    $('#dialog_productdetails').dialog({
        autoOpen: false,
        //modal: true,
    });

    /*
    |------------------------------------------------
    | Button Callbacks
    |------------------------------------------------
    */

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

    $('#btn_productdetails_download').on('click', function(e)
    {
        // send download request to server via AJAX, do nothing else on success (other than maybe a "your download starts now" message
        AjaxBlob({
            'action':'download',
            'pid':$('#dialog_productdetails').attr('productid'),
            'grayscale':$('#productdetails_colour').prop('checked') ? 0 : 1,
            'scale':$('#productdetails_scale').val(),
        },  function(response)
            {
                let url = window.URL.createObjectURL(response);
                let srcurl = $('#productdetails_img').prop('src');
                let a = $('<a>');
                a.css('display','none');
                a.prop('href',url);
                a.prop('download', srcurl.slice(srcurl.lastIndexOf('/')+1) );
                a[0].click();
                a.remove();
                window.URL.revokeObjectURL(url);
                FlashSuccess( "Bild wurde heruntergeladen." );
            }
        );
    });

    $("#btn_filter_reset").on("click", function(e)
    {
        $("#filter_text").prop('value', '');
        $("#check_filter_owned").prop('checked', true);
        $("#check_filter_bought").prop('checked', true);
        $("#check_filter_buyable").prop('checked', true);
        SidebarTagView.uncheckAll();
        GalleryProductView.updateFilter();
    });

    $('#btn_delete').on('click', function(e)
    {
        // send delete requests to server via AJAX, remove based on response (or simply refresh all), give clear success message (including number of actually deleted items?)
        let targets = GalleryProductView.getAllCheckedID();
        AjaxActionAndFlash({
            'action':'deleteproduct',
            'pid':JSON.stringify(targets),
        },  function(response)
            {
                // notification
                if( response.length == 0 )
                {
                    FlashSuccess( targets.length +" Bilder erfolgreich gelöscht." );
                }
                else if( response.length < targets.length )
                {
                    FlashWarning( response.length +" Bilder konnten nicht gelöscht werden:<br>"+ response.join("<br>") );
                }
                else
                {
                    FlashError( "Die Bilder konnten nicht gelöscht werden:<br>"+ response.join("<br>") );
                }
                // remove GalleryProductView (and ShopcartProductView)
                for(let i = 0; i < targets.length; ++i)
                {
                    if( !response[i] )
                    {
                        GalleryProductView.remove( targets[i] );
                    }
                }
            }
        );
    });

    $('#btn_download').on('click', function(e)
    {
        // send download requests to server via AJAX, do nothing else on success (other than maybe a "your download starts now" message
        let targets = GalleryProductView.getAllCheckedID();
        AjaxBlob({
            'action':'download',
            'pid':JSON.stringify(targets),
        },  function(response)
            {
                let url = window.URL.createObjectURL(response);
                let a = $('<a>');
                a.css('display','none');
                a.prop('href',url);
                a.prop('download', 'downloaded-images.zip' );
                a[0].click();
                a.remove();
                window.URL.revokeObjectURL(url);
                FlashSuccess( "Bilder wurden heruntergeladen." );
            }
        );
    });

    $('#btn_addcart').on('click', function(e)
    {
        // tell server to add these to the cart, give clear success message (including number of actually added items?), update #shopcart_list if it exists
        let targets = GalleryProductView.getAllCheckedID();
        AjaxActionAndFlash({
            'action':'createshopcart',
            'pid':JSON.stringify(targets),
        },  function(response)
            {
                // notification
                if( response.length == 0 )
                {
                    FlashSuccess( targets.length +" Bilder erfolgreich eingeladen." );
                }
                else if( response.length < targets.length )
                {
                    FlashWarning( response.length +" Bilder konnten nicht eingeladen werden:<br>"+ response.join("<br>") );
                }
                else
                {
                    FlashError( "Die Bilder konnten nicht eingeladen werden:<br>"+ response.join("<br>") );
                }
                // remove SidebarTagViews
                for(let i = 0; i < targets.length; ++i)
                {
                    if( !response[i] )
                    {
                        GalleryProductView.CopyToShopcart( targets[i] );
                    }
                }
            }
        );
    });

    $('#btn_showcart').on('click', function(e)
    {
        $('#dialog_shopcart').dialog('open');
    });

    $('#btn_showcart, #btn_addcart').droppable({
        accept: ".gallery-product-draggable",
        drop: function(e, ui)
        {
            AjaxActionAndFlash({
                'action':'createshopcart',
                'pid':ui.draggable.attr('pid'),
            },  function(response)
                {
                    FlashSuccess("Bild eingeladen!");
                    GalleryProductView.CopyToShopcart( ui.draggable.attr('pid') );
                }
            );
        }
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

    $('#check_filter_owned, #check_filter_bought, #check_filter_buyable').on('click', GalleryProductView.updateFilter );

    $('#select_order').on('change', function()
    {
        let order = $(this).val();
        GalleryProductView.updateOrder( order );
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
            if(!e.originalEvent.dataTransfer) return;
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

    let shopcarted = [];
    let fd = new FormData();
    fd.append('action', 'indexshopcart');
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
            shopcarted = response;
        },
        error: function(jqxhr, status, exception)
        {
            console.log(exception);
            console.log(jqxhr);
        },
    });

    fd = new FormData();
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
                    success: function(response_model)
                    {
                        new GalleryProductView(response_model);
                        if( shopcarted.indexOf(response_model.pid) != -1 )
                            new ShopcartProductView(response_model);

                        if( i = response.length - 1 )
                            GalleryProductView.updateOrder('new_first'); // init
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
