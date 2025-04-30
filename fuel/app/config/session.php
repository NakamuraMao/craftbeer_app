<?php

return [
    'driver' => 'cookie', // or 'native'
    'cookie_name' => 'fuelcid',
    'expiration_time' => 7200, // 2時間
    'expire_on_close' => false,
    'cookie_path' => '/',
    'cookie_domain' => '',
    'cookie_secure' => true, // HTTPS限定
    'cookie_http_only' => true, // JSからのアクセス不可 (XSS対策)
    'cookie_same_site' => 'Lax', // or 'Strict'　外部からのPOSTを制限（CSRF対策）
];
