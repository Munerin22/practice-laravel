<?php
return[
    // ユーザー画面用のクッキー名称
    'session_cookie' => env('SESSION_COOKIE', str_slug(env('APP_NAME', 'laravel'), '_').'_session'),
    // 管理画面用のクッキー名称
    'session_cookie_admin' => env('SESSION_COOKIE_ADMIN', str_slug(env('APP_NAME', 'laravel'), '_').'_session'),
]
?>
