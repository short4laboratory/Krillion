<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
     * Where answer popularity comes from: Wikipedia page views (how often people look an answer up)
     * and Datamuse word frequency (how common the word is in English).
     *
     * Wikimedia allows ~10 requests/minute for clients without contact details and ~200/minute
     * when the User-Agent includes contact info (an email or URL), so set WIKIPEDIA_USER_AGENT
     * to something like "MyWordGame/1.0 (you@example.com)" and raise the rate to match.
     */
    'wikipedia' => [
        'user_agent' => env('WIKIPEDIA_USER_AGENT', 'WordGameBot/1.0 (Laravel HTTP client)'),
        'requests_per_minute' => (int) env('WIKIPEDIA_REQUESTS_PER_MINUTE', 9),
        'timeout' => (int) env('WIKIPEDIA_TIMEOUT', 10),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
