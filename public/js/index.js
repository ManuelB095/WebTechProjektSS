"use strict";
//"use strict" applies important security measures,
//but also forces us to comply with declaration and such. -LG

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

});
