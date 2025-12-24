<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Evolution API Base URL
    |--------------------------------------------------------------------------
    |
    | Aqui você define a URL base onde sua instância da Evolution API está
    | rodando. Exemplo: https://api.suadominio.com
    |
    */
    'base_url' => env('EVOLUTION_BASE_URL', 'http://localhost:8080'),

    /*
    |--------------------------------------------------------------------------
    | Evolution API Global Key
    |--------------------------------------------------------------------------
    |
    | A API Key global para autenticação administrativa nas requisições.
    | Mantenha esta chave segura no seu arquivo .env.
    |
    */
    'api_key' => env('EVOLUTION_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Instance Settings
    |--------------------------------------------------------------------------
    |
    | Configurações padrão que serão aplicadas ao criar novas instâncias,
    | como comportamentos de Webhook ou configurações do Chatwoot.
    |
    */
    'defaults' => [
        'qrcode' => true,
        'reject_call' => false,
        'groups_ignore' => true,
    ],
];
