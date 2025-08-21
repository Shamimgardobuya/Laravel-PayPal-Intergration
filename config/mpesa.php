<?php

return [
    'username' => env('MPESA_CONSUMER_KEY'),
    'password' => env('MPESA_CONSUMER_SECRET'),
    'passkey' => env('MPESA_PASS_KEY'),
    'short_code' => env('MPESA_SHORT_CODE'),
    'account_ref' => env('AccountReference'),
    'callback_url'=> env('MPESA_CALLBACK_URL'),
    'validate_url' => env('MPESA_VALIDATE_URL'),
    'short_code_register' => env('MPESA_SHORT_CODE_REGISTER')


];