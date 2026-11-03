<?php

$config = require __DIR__ . '/config.php';
$db = $config['db'];

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $db['host'],
    $db['port'],
    $db['name'],
    $db['charset']
);

try {
    $pdo = new PDO($dsn, $db['user'], $db['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><html lang="ru"><head><meta charset="UTF-8"><title>Ошибка</title></head><body>';
    echo '<p>Не удалось подключиться к базе данных. Проверьте, что MySQL в MAMP запущен.</p>';
    echo '</body></html>';
    exit;
}
