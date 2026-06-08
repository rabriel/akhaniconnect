<?php

return [
    'api_key' => env('VERIFYNOW_API_KEY'),
    'mode' => env('VERIFYNOW_MODE', 'sandbox'),
    'base_url' => env('VERIFYNOW_BASE_URL', 'https://www.verifynow.co.za/api/external'),
    'timeout' => env('VERIFYNOW_TIMEOUT', 30),
];
