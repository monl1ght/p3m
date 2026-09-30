<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // SEC-CORS-01: Env-driven allowed origins. No wildcard fallback.
    //
    // Priority:
    //   1. CORS_ALLOWED_ORIGINS env var (CSV) — if set, used as-is
    //   2. Fallback to APP_URL — safe default for both local and production
    //
    // Local:      APP_URL=http://localhost      → allowed: ["http://localhost"]
    // Production: APP_URL=https://p3m.polibang.ac.id → allowed: ["https://p3m.polibang.ac.id"]
    // Multi-origin: CORS_ALLOWED_ORIGINS=https://p3m.polibang.ac.id,https://admin.polibang.ac.id
    'allowed_origins' => array_filter(
        array_map('trim', explode(',', env('CORS_ALLOWED_ORIGINS', env('APP_URL', 'http://localhost')))),
        fn (string $v) => $v !== ''
    ),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
