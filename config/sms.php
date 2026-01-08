<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SMS Provider
    |--------------------------------------------------------------------------
    |
    | Supported providers: "log", "twilio", "semaphore"
    | - log: Writes SMS to storage/logs/sms.log (free, for testing)
    | - twilio: Twilio SMS API (free trial available)
    | - semaphore: Semaphore SMS Gateway (Philippine-based)
    |
    */
    'provider' => env('SMS_PROVIDER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | SMS Enabled
    |--------------------------------------------------------------------------
    |
    | Master switch to enable/disable SMS notifications globally
    |
    */
    'enabled' => env('SMS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Default Country Code
    |--------------------------------------------------------------------------
    |
    | Default country code for phone numbers (63 for Philippines)
    |
    */
    'default_country_code' => env('SMS_DEFAULT_COUNTRY_CODE', '63'),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Maximum number of SMS messages per user per day
    |
    */
    'rate_limit' => env('SMS_RATE_LIMIT', 100),

    /*
    |--------------------------------------------------------------------------
    | Twilio Configuration
    |--------------------------------------------------------------------------
    */
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'phone_number' => env('TWILIO_PHONE_NUMBER'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Semaphore Configuration
    |--------------------------------------------------------------------------
    */
    'semaphore' => [
        'api_key' => env('SEMAPHORE_API_KEY'),
        'sender_name' => env('SEMAPHORE_SENDER_NAME', 'CMU_GCC'),
        'api_url' => 'https://api.semaphore.co/api/v4/messages',
    ],
];
