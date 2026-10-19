<?php

return [
    'rickandmorty' => [
        'url' => env('RICKANDMORTY_URL', 'https://rickandmortyapi.com/api'),
        'timeout' => (int)env('RICKANDMORTY_TIMEOUT', 3),
        'coolofftime' => (int)env('RICKANDMORTY_COOLOFFTIME', 30),
        'dailylimit' => (int)env('RICKANDMORTY_DAILYLIMIT', 9000),
    ],

];
