<?php

return [
    'redirect_url' => env('APP_URL') . '/auth/steam/handle',

    /*
     * Realm override. Bypass domain ban by Valve.
     * Use alternative domain with redirection to main for authentication (banned by valve).
     */
    'realm' => env('APP_DOMAIN'),

    /*
     * API Key (set in .env file) [http://steamcommunity.com/dev/apikey]
     */
    'api_key' => env('STEAM_API_KEY'),

    /*
     * Is using https ?
     */
    'https' => env('STEAM_HTTPS'),
];