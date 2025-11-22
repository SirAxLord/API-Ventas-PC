<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Allowed Paths
    |--------------------------------------------------------------------------
    | Se aplica a rutas API y versión actual. Ajusta según necesites.
    */
    'paths' => ['api/*', 'v1/*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    */
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    | Usa variable de entorno para no hardcodear dominios. Ejemplo en .env:
    | CORS_ALLOWED_ORIGINS=http://localhost:3000,https://admin.midominio.com
    */
    'allowed_origins' => array_filter(array_map('trim', explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000')))),
    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    */
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'Accept', 'Origin'],

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    */
    'exposed_headers' => ['Authorization'],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    */
    'max_age' => 3600,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    | TRUE si necesitas enviar cookies / sesiones (normalmente FALSE para API token).
    */
    'supports_credentials' => false,
];
