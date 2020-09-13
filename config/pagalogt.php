<?php

return [
    'test' => [
        'token'         => env('PAGALO_TEST_TOKEN'),
        'iden_empresa'  => env('PAGALO_TEST_IDEN_EMPRESA'),
        'key_public'    => env('PAGALO_TEST_KEY_PUBLIC'),
        'key_secret'    => env('PAGALO_TEST_KEY_SECRET'),
    ],
    'production' => [
        'token'         => env('PAGALO_TOKEN'),
        'iden_empresa'  => env('PAGALO_IDEN_EMPRESA'),
        'key_public'    => env('PAGALO_KEY_PUBLIC'),
        'key_secret'    => env('PAGALO_KEY_SECRET'),
    ],
    'environment'       => env('PAGALO_ENVIRONMENT'),
    'use_cybersource'   => env('PAGALO_USE_CYBERSOURCE')
];
