<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Pengaturan ini menentukan domain mana yang boleh mengakses API Laravel kamu.
    | Disesuaikan agar kompatibel dengan React/Vite yang berjalan di localhost:5173.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Izinkan semua jenis method (GET, POST, PUT, DELETE, dll)
    'allowed_methods' => ['*'],

    // ⚠️ Ubah dari '*' menjadi domain asal frontend kamu
    // supaya preflight request (OPTIONS) tidak ditolak
    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
    ],

    // Tidak perlu pattern tambahan
    'allowed_origins_patterns' => [],

    // Izinkan semua jenis header (Authorization, Content-Type, dll)
    'allowed_headers' => ['*'],

    // Tidak perlu expose header khusus
    'exposed_headers' => [],

    // Maksimal waktu cache preflight
    'max_age' => 0,

    // ✅ Ubah ke true jika kamu menggunakan token (Authorization Bearer ...)
    'supports_credentials' => true,
];
