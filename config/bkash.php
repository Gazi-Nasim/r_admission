<?php

return [
    "api_url" => env('BKASH_API_URL', 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/'),

    "user_name" => env('BKASH_USER_NAME', "sandboxTokenizedUser02"),

    "password" => env('BKASH_PASSWORD', "sandboxTokenizedUser02@12345"),

    "app_key" => env('BKASH_APP_KEY', "4f6o0cjiki2rfm34kfdadl1eqq"),

    "app_secret" => env('BKASH_APP_SECRET', "2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b"),

    'return_url' => 'bkash.return'
];
