<?php

    $host 							= $_SERVER['HTTP_HOST'];

    $data 							= explode(".",$host);
    $url 							= $data[0];


    $redirected_url = $twitterRedirected_url = '/';
    if(str_contains($url, 'canada'))
    {
        $redirected_url = 'https://canada.nris.com/google-callback/';
        $twitterRedirected_url = 'https://canada.nris.com/twitter-callback/';
    }
    else if(str_contains($url, 'australia'))
    {
        $redirected_url = 'https://australia.nris.com/google-callback/';
        $twitterRedirected_url = 'https://australia.nris.com/twitter-callback/';
    }			
    else if(str_contains($url, 'uk'))
    {
        $redirected_url = 'https://uk.nris.com/google-callback/';
        $twitterRedirected_url = 'https://uk.nris.com/twitter-callback/';
    }
    else if(str_contains($url, 'newzealand'))
    {
        $redirected_url = 'https://newzealand.nris.com/google-callback/';
        $twitterRedirected_url = 'https://newzealand.nris.com/twitter-callback/';
    }
    else
    {
        $redirected_url = 'https://nris.com/google-callback/';
        $twitterRedirected_url = 'https://nris.com/twitter-callback/';
    }

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


    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'), //USE FROM Google DEVELOPER ACCOUNT
        'client_secret' => env('GOOGLE_CLIENT_SECRET'), //USE FROM Google DEVELOPER ACCOUNT
        'redirect' => $redirected_url, // UPDATE THIS URL IN THE GOOGLE DEVELOPER CONSOLE
    ],
    
    'facebook' => [
        'client_id' => env('FB_CLIENT_ID'), //USE FROM Facebook DEVELOPER ACCOUNT
        'client_secret' => env('FB_CLIENT_SECRET'), //USE FROM Facebook DEVELOPER ACCOUNT
        'redirect' => env('FB_CLIENT_REDIRECT_URL'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => $twitterRedirected_url, //env('TWITTER_CLIENT_REDIRECT_URL'),
    ],

];
