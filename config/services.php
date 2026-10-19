<?php

return [
    'rickandmorty' => [
        'url' => env('RICKANDMORTY_URL', 'https://rickandmortyapi.com/api'),
        'timeout' => (int)env('RICKANDMORTY_TIMEOUT', 3),
    ],

];
