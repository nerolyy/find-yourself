<?php

require_once __DIR__ . '/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');

    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS'])
            && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax',
        'path' => '/',
    ]);

    session_start();
}

header('Cache-Control: no-store');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function redirectTo(string $page): void
{
    header('Location: ' . $page);
    exit;
}

function postText(string $key): string
{
    $value = $_POST[$key] ?? '';

    return is_string($value) ? $value : '';
}

function csrfField(): void
{
    echo '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars((string) $_SESSION['csrf_token'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '">';
}

function checkCsrf(): void
{
    if (!hash_equals(
        $_SESSION['csrf_token'],
        postText('csrf_token')
    )) {
        http_response_code(403);
        exit('Форма устарела. Обнови страницу и попробуй снова.');
    }
}

function currentUser(): ?array
{
    global $pdo;

    if (empty($_SESSION['user_id'])) {
        return null;
    }

    $query = $pdo->prepare(
        'SELECT id, first_name, last_name, email, role, created_at
         FROM users
         WHERE id = ?'
    );

    $query->execute([$_SESSION['user_id']]);
    $user = $query->fetch();

    if (!$user) {
        unset($_SESSION['user_id']);
        return null;
    }

    return $user;
}

function requireUser(): array
{
    $user = currentUser();

    if (!$user) {
        redirectTo('account.php?mode=login');
    }

    return $user;
}

function requireAdmin(): array
{
    $user = requireUser();

    if ($user['role'] !== 'admin') {
        http_response_code(403);
        exit('Эта страница доступна только администратору.');
    }

    return $user;
}

function signIn(int $userId): void
{
    session_regenerate_id(true);

    $_SESSION = [
        'user_id' => $userId,
        'csrf_token' => bin2hex(random_bytes(32)),
    ];
}

function roleName(string $role): string
{
    $names = [
        'user' => 'Пользователь',
        'moderator' => 'Модератор',
        'admin' => 'Администратор',
    ];

    return $names[$role] ?? 'Пользователь';
}