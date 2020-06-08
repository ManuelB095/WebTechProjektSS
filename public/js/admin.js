"use strict";
//"use strict" applies important security measures,
//but also forces us to comply with declaration and such. -LG


/*
|------------------------------------------------
| Userlist Entry
|------------------------------------------------
*/

class ListUserView
{
    constructor(model)
    {
        this._model = model;

        this.div = $("<div>");
        this.div.addClass("userlist-item");

        this.btn_profile = $("<a>");
        this.btn_profile.html( this._model.username );
        this.btn_profile.on('click', this.onclick_profile.bind(this) );
        this.div.append( this.btn_profile );

        this.btn_viewpurchases = $("<button>");
        this.btn_viewpurchases.html('Liste der Käufe');
        this.btn_viewpurchases.on('click', this.onclick_viewpurchases.bind(this) );
        this.div.append( this.btn_viewpurchases );

        this.btn_pwreset = $("<button>");
        this.btn_pwreset.html('PW Reset');
        //this.btn_pwreset.on('click', this.onclick_pwreset.bind(this) );
        this.div.append( this.btn_pwreset );

        $('#userlist').append(this.div);
    }

    onclick_profile(e)
    {
        $('#profileadmin_username').val( this._model.username );
        $('#profileadmin_email').val( this._model.email );
        $('#profileadmin_salutation').val( this._model.title );
        $('#profileadmin_firstname').val( this._model.firstname );
        $('#profileadmin_lastname').val( this._model.lastname );
        $('#profileadmin_address').val( this._model.address );
        $('#profileadmin_town').val( this._model.location );
        $('#profileadmin_postcode').val( this._model.plz );
        $('#profileadmin_isactive').prop('checked', this._model.is_active );
        $('#dialog_profileadmin').dialog('open');
    }

    onclick_viewpurchases(e)
    {
        // ask server for a list of all purchases done by this user (PID and filename please), then display those in a scrollable dialog
        AjaxActionAndFlash({
            'action':'indexuserboughtproduct',
            'username':this._model.username,
        },  function(response)
            {
                // clear old
                $('#listpurchases').children().remove();

                // headers
                let tr = $('<tr>');
                let th = $('<th>');
                th.html("Vorschau");
                tr.append(th);

                th = $('<th>');
                th.html("Prod.-ID");
                tr.append(th);

                th = $('<th>');
                th.html("Dateiname");
                tr.append(th);

                $('#listpurchases').append(tr);

                // fill
                for(let i = 0; i < response.length; ++i)
                {
                    let tr = $('<tr>');

                    let imgtd = $('<td>');
                    let img = $('<img>');
                    img.prop('src', "ugc/thumb/"+ response[i][0] +".jpg" );
                    imgtd.append(img);
                    tr.append(imgtd);

                    let pid = $('<td>');
                    pid.html( response[i][0] );
                    tr.append(pid);

                    let filename = $('<td>');
                    filename.html( response[i][1] );
                    tr.append(filename);

                    $('#listpurchases').append(tr);
                }
                // show
                $('#dialog_listpurchases').dialog('open');
            }
        );
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

    $('#dialog_profileadmin').dialog({
        autoOpen: false,
        modal: false,
        buttons: {
            'Profil Ändern': function()
            {
                // tell server to logout, reload page if successful
                let fd = new FormData( $('#dialog_profileadmin').find('form')[0] );
                fd.append('action','edituser');
                AjaxActionAndFlash(fd, function(response)
                    {
                        $('#dialog_profileadmin').dialog('close');
                        FlashSuccess("Nutzer geändert!");
                    }
                );
            },
        },
    });

    $('#dialog_listpurchases').dialog({
        autoOpen: false,
        modal: false,
    });
    
    /*
    |------------------------------------------------
    | Population
    |------------------------------------------------
    */

    let fd = new FormData();
    fd = new FormData();
    fd.append('action', 'indexuser');
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
                fd.append('action', 'getuser');
                fd.append('username', response[i]);
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
                        new ListUserView(response);
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
