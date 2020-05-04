<?php

return [

    /*
    |------------------------------------------------
    | Mail Connection
    |------------------------------------------------
    |
    | These values will be used to connect
    | the web server to the e-mail server.
    |
    */

    'host' => 'smtp.mailgun.org',
    //'port' => '587',

    'protocol' => 'smtp',
    'encryption' => 'tls',

    /*
    |------------------------------------------------
    | Mail Credentials
    |------------------------------------------------
    |
    | These values will be used to authenticate
    | the web server to the e-mail server.
    |
    */

    'username' => 'webtech',
    'password' => '1234',

    /*
    |------------------------------------------------
    | "From" Address
    |------------------------------------------------
    |
    | All e-mails sent by the application
    | will be sent from this name and address.
    |
    */

    'from' => [
        'address' => 'noreply@example.com',
        'name' => 'Do Not Reply',
    ],

];
