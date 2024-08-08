<?php

return [
    'enot' => [
        'secret_word' => env('ENOT_SECRET_WORD'),
        'extra_secret_word' => env('ENOT_EXTRA_SECRET_WORD'),
        'merchant_id' => env('ENOT_MERCHANT_ID'),
    ],

    'freekassa' => [
        'api_key' => env('FREEKASSA_API_KEY'),
        'merchant_id' => env('FREEKASSA_MERCHANT_ID'),
        'secret_word' => env('FREEKASSA_SECRET_WORD'),
        'secret_word_2' => env('FREEKASSA_SECRET_WORD_2'),
    ],

    'skinsback' => [
        'client_id' => env('SKINSBACK_CLIENT_ID'),
        'client_secret' => env('SKINSBACK_CLIENT_SECRET')
    ],

    'xmpay' => [
        'shop_id' => env('XMPAY_SHOP_ID'),
        'public_key' => env('XMPAY_PUBLIC_KEY'),
        'secret_key' => env('XMPAY_SECRET_KEY')
    ],

    'qiwi_comment' => [
        'phone_number' => env('QIWI_COMMENT_PHONE_NUMBER'),
        'api_key' => env('QIWI_COMMENT_API_KEY'),
        'public_key' => env('QIWI_COMMENT_PUBLIC_KEY'),
        'secret_key' => env('QIWI_COMMENT_SECRET_KEY')
    ],

    'qiwi' => [
        'phone_number' => env('QIWI_PHONE_NUMBER'),
        'api_key' => env('QIWI_API_KEY'),
        'public_key' => env('QIWI_PUBLIC_KEY'),
        'secret_key' => env('QIWI_SECRET_KEY')
    ],
];
