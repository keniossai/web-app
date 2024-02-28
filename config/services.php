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

    'azure'   => [
        'client_id'     => env('AZURE_CLIENT_ID', false),
        'client_secret' => env('AZURE_CLIENT_SECRET', false),
        'tenant'        => env('AZURE_TENANT_ID', false),
        'redirect'      => env('APP_URL') . '/login/azure/callback',
        'name'          => 'Microsoft Azure',
        'auto_register' => env('AZURE_AUTO_REGISTER', false),
        'auto_confirm'  => env('AZURE_AUTO_CONFIRM_EMAIL', false),
    ],

];
