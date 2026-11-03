<?php

require __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Используй кнопку выхода в профиле.');
}

checkCsrf();

$_SESSION = [];

$params = session_get_cookie_params();

setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => $params['path'],
    'domain' => $params['domain'],
    'secure' => $params['secure'],
    'httponly' => $params['httponly'],
    'samesite' => $params['samesite'],
]);

session_destroy();

redirectTo('account.php?mode=login');