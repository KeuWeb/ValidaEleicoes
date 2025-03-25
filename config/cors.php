<?php

return [
    'paths' => ['api/*', 'login', 'register'], // Defina os caminhos que precisam de CORS
    'allowed_methods' => ['*'], // Métodos permitidos
    'allowed_origins' => [
        'http://127.0.0.1:5173',
        'https://eleicao.test',
        'http://eleicao.test/adm',
        'http://eleicao.test/booth',
    ],
    'allowed_headers' => ['*'], // Cabeçalhos permitidos
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
