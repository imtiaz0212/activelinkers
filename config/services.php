<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme'   => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'ranklord_api_key'      => 'bW96c2NhcGUta2M4bUM3c01pWjpFWGlBeHhFOFFrU3M4WXdzbWFTZ1JTOXRvek9zcFZCcQ==',

    // send pulse api info
    'sendpulse_api_user_id' => '80ea48703a7b3c42bd9a1f0b0142bfb9',
    'sendpulse_api_secret'  => 'c109fdd72c01ca5241d8ee782e25e080',
];
