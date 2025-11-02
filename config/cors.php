<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'api-rest/cms/*',
        'data/*', // ENVIO DE DATOS
        'auth/with/*', // ENVIO DE DATOS
        'uploads/*'//UPLOAD DATA
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://kaypitex.com',
        'http://localhost:6969',
        'http://localhost:49394',//MY HOME
        "http://localhost:49781",
        "http://192.168.0.101",
        "http://192.168.137.1",
        'https://192.168.137.1',
        'http://192.168.137.1:6969',

    ],
    'allowed_origins_patterns' => [],
   /* 'allowed_origins_patterns' => [
        '^http:\/\/(localhost|127\.0\.0\.1)(:[0-9]+)?$',
        '/^https?:\/\/(?:localhost|127\.0\.0\.1)(?::\d+)?$/', // localhost / 127.0.0.1 con puerto
        '^https://192.168.137.1$'//CHANGE IP
    ],
*/
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,


];
