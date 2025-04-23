<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Your Mollie API key. The API key is used to authenticate all API requests. 
    | You can generate API keys in the Mollie Dashboard.
    |
    */
    'key' => env('MOLLIE_KEY', 'test_fNQUsCGheJJPRebKyRMejHkTM4e9Fk'),

    /*
    |--------------------------------------------------------------------------
    | Profile ID
    |--------------------------------------------------------------------------
    |
    | If you're having multiple Mollie profiles, you can specify which profile
    | you want to use.
    |
    */
    'profile_id' => env('MOLLIE_PROFILE_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Component Settings
    |--------------------------------------------------------------------------
    |
    | Some payment methods have their own Component UI, which can be customized.
    | The default styles of the components will reflect your Mollie Dashboard
    | settings.
    |
    */
    'components' => [
        'locale' => env('MOLLIE_COMPONENTS_LOCALE', 'en'),
        'theme' => [
            'color' => env('MOLLIE_COMPONENTS_COLOR', '#07f'),
            'fontFamily' => env('MOLLIE_COMPONENTS_FONT_FAMILY', '"Helvetica Neue", Helvetica, Arial, sans-serif'),
        ],
    ],
]; 