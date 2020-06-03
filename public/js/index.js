"use strict";
//"use strict" applies important security measures,
//but also forces us to comply with declaration and such. -LG

/*
|------------------------------------------------
| AJAX Helper & Message Flashes
|------------------------------------------------
|
| Could also use Toasts instead of Flashes. -LG
| https://www.w3schools.com/bootstrap4/bootstrap_toast.asp
|
*/

function ResetFlash()
{
    $('#flash_msg').removeClass('alert-success');
    $('#flash_msg').removeClass('alert-warning');
    $('#flash_msg').removeClass('alert-danger');
    $('#flash_msg_icon').removeClass('ui-icon-check');
    $('#flash_msg_icon').removeClass('ui-icon-notice');
    $('#flash_msg_icon').removeClass('ui-icon-alert');
}

function ShowFlash(text)
{
    $('#flash_msg_text').html(text);
    //$('#flash_msg').show( 'highlight', {}, 500 );
    $('#flash_msg').show( 'blind', {}, 300 );
}

function FlashSuccess(text)
{
    if(text == null || text == '')
    {
        text = "Erfolgreich ausgeführt.";
    }
    ResetFlash();
    $('#flash_msg').addClass('alert-success');
    $('#flash_msg_icon').addClass('ui-icon-check');
    ShowFlash(text);
}

function FlashWarning(text)
{
    if(text == null || text == '')
    {
        text = "Unbekannte Komplikationen sind aufgetreten.";
    }
    ResetFlash();
    $('#flash_msg').addClass('alert-warning');
    $('#flash_msg_icon').addClass('ui-icon-notice');
    ShowFlash(text);
}

function FlashError(text)
{
    if(text == null || text == '')
    {
        text = "Falls es die gewünschte Ressource gibt, konnte nicht darauf zugegriffen werden.";
    }
    ResetFlash();
    $('#flash_msg').addClass('alert-danger');
    $('#flash_msg_icon').addClass('ui-icon-alert');
    ShowFlash(text);
}

function AjaxActionAndFlash(data, onsuccess)
{
    $('#flash_msg').hide( 'fade', {}, 200 );

    let fd;
    if( data != null )
    {
        fd = new FormData();
        for( let key in data )
        {
            fd.append( key, data[key] );
        }
    }

    $.ajax({
        url: 'actions.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        dataType: 'json',
        success: onsuccess,
        error: function(jqxhr, status, exception)
        {
            FlashError(jqxhr.responseText);
        },
    });
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

    $('#dialog_register').dialog({
        autoOpen: false,
        modal: true,
        /*buttons: {
            'Registrieren': function() {
                
            },
        },*/
    });

    $('#dialog_login').dialog({
        autoOpen: false,
        modal: true,
        /*buttons: {
            'Anmelden': function() {
                
            },
        },*/
    });
    
    /*
    |------------------------------------------------
    | Login Handling
    |------------------------------------------------
    */

    let btn_login = $('#btn_login');
    if( btn_login )
    {
        btn_login.on('click', function(e)
        {
            // tell server to login, reload page if successful
            AjaxActionAndFlash({
                'action':'login',
                'username':$('#login_username').val(),
                'password':$('#login_password').val(),
            },  function(response)
                {
                    location.reload();
                }
            );
        });
    }

    let btn_logout = $('#btn_logout');
    if( btn_logout )
    {
        btn_logout.on('click', function(e)
        {
            // tell server to logout, reload page if successful
            AjaxActionAndFlash({
                'action':'logout',
            },  function(response)
                {
                    location.reload();
                }
            );
        });
    }

});
