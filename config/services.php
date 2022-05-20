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

    'slack' => [
        'client_id' => env('SLACK_CLIENT_ID'),
        'client_secret' => env('SLACK_CLIENT_SECRET'),
        'app_id' => env('SLACK_APP_ID'),
        'access_redirect' => env('SLACK_ACCESS_REDIRECT'),
        'redirect' => env('SLACK_REDIRECT_URL'),
        'callback' => env('SLACK_CALLBACK_URL'),
        'landing_page' => env('SLACK_LANDING_PAGE'),
        'verify_code' => env('SLACK_VERIFY_CODE'),
        'slack_message_response_icon' => env('SLACK_MESSAGE_RESPONSE_ICON'),
        'slack_emoji_checkmark' => env('SLACK_EMOJI_CHECKMARK'),
        'slack_emoji_crossmark' => env('SLACK_EMOJI_CROSSMARK'),
        'slack_emoji_wastebin' => env('SLACK_EMOJI_WASTEBIN'),
        'slack_emoji_construction' => env('SLACK_EMOJI_CONSTRUCTION'),
        'slack_inspirational' => env('SLACK_INSPIRATIONAL'),
        'slack_thumbs_up' => env('SLACK_THUMBS_UP'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT_URL'),
        'callback' => env('GITHUB_CALLBACK_URL'),
        'base_auth_route' => env('GITHUB_BASE_AUTH_URL'),
    ],
];
