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
    if( data instanceof FormData )
    {
        fd = data;
    }
    else if( data != null )
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

// https://stackoverflow.com/questions/17657184/using-jquerys-ajax-method-to-retrieve-images-as-a-blob
function AjaxBlob(data, onsuccess)
{
    $('#flash_msg').hide( 'fade', {}, 200 );

    let fd;
    if( data instanceof FormData )
    {
        fd = data;
    }
    else if( data != null )
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
        //dataType: 'blob',
        xhr: function() 
        {
            var xhr = new XMLHttpRequest();
            xhr.responseType= 'blob'
            return xhr;
        },
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
        buttons: {
            'Registrieren': function()
            {
                if( $('#register_password').val() != $('#register_password_repeat').val() )
                {
                    return;
                }

                // tell server to register, reload page if successful
                let fd = new FormData( $('#dialog_register').find('form')[0] );
                fd.append('action','createuser');
                AjaxActionAndFlash(fd, function(response)
                    {
                        location.reload();
                    }
                );
            },
        },
    });

    $('#dialog_login').dialog({
        autoOpen: false,
        modal: true,
        /*buttons: {
            'Anmelden': function()
            {
                
            },
        },*/
    });

    $('#dialog_profile').dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            'Profil Ändern': function()
            {
                // tell server to logout, reload page if successful
                let fd = new FormData( $('#dialog_profile').find('form')[0] );
                fd.append('action','edituser');
                AjaxActionAndFlash(fd, function(response)
                    {
                        location.reload();
                    }
                );
            },
        },
    });

    /*
    |------------------------------------------------
    | Form Validation
    |------------------------------------------------
    */

    $('#register_password, #register_password_repeat').on('change', function()
    {
        if( $('#register_password').val() == $('#register_password_repeat').val() )
        {
            $('#register_password_repeat').css('color', 'inherit');
        }
        else
        {
            $('#register_password_repeat').css('color', 'red');
        }
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

    let btn_profile = $('#btn_profile');
    if( btn_profile )
    {
        btn_profile.on('click', function(e)
        {
            // ask server who we are
            AjaxActionAndFlash({
                'action':'getuser',
            },  function(response)
                {
                    $('#profile_username').val( response.username );
                    $('#profile_email').val( response.email );
                    $('#profile_salutation').val( response.title );
                    $('#profile_firstname').val( response.firstname );
                    $('#profile_lastname').val( response.lastname );
                    $('#profile_address').val( response.address );
                    $('#profile_town').val( response.location );
                    $('#profile_postcode').val( response.plz );
                    $('#dialog_profile').dialog('open');
                }
            );
        });
    }

    let btn_register = $('#btn_register');
    if( btn_register )
    {
        btn_register.on('click', function(e)
        {
            $('#dialog_register').dialog('open');
        });
    }

});
