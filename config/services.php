<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Config-Init
    //https://developers.facebook.com/apps/642760929635985/settings/basic/
    'facebook'=>[
        'client_id'=>env('facebook_client_id'),
        'client_secret'=>env('facebook_client_secret'),
        'redirect'=>env('facebook_redirect'),

    ],
    //https://console.developers.google.com/apis/credentials?clientUpdateTime=2020-04-16T19:37:10.722315Z&project=premium-apex-201813&hl=ES
    'google'=>[
        'client_id'=>env('google_client_id'),
        'client_secret'=>env('google_client_secret'),
        'redirect'=>env('google_redirect'),

    ]
];
