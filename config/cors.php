<?php

return [

    // Quais rotas disparam o CORS
    'paths' => ['api/*'],

    // Métodos HTTP permitidos
    'allowed_methods' => ['*'],

    // Origens permitidas (ajuste ao seu front ou use '*' em dev)
    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
        // '*'  // descomente para liberar geral em dev
    ],

    // Cabeçalhos que o cliente pode enviar
    'allowed_headers' => ['*'],

    // Cabeçalhos expostos na resposta (geralmente vazio)
    'exposed_headers' => [],

    // Tempo de cache do preflight (segundos)
    'max_age' => 0,

    // Se usar cookies/autenticação entre origens
    'supports_credentials' => false,

];
