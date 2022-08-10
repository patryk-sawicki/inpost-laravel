<?php
return [
    'api_key' => env('INPOST_API_KEY', null),
    'sandbox' => env('INPOST_SANDBOX', false),
    'api_url' => env('INPOST_API_URL', 'https://api-shipx-pl.easypack24.net'),
    'sandbox_url' => env('INPOST_SANDBOX_URL', 'https://sandbox-api-shipx-pl.easypack24.net'),

    /*Cache time*/
    'cache_time' => env('INPOST_CACHE_DEFAULT_TTL', 86400),
];