<?php

require __DIR__ . '/includes/auth.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if (currentUser()) {
    redirectTo('index.php');
}

$isLogin = ($_GET['mode'] ?? '') === 'login';

$error = '';
$firstName = '';
$lastName = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();

    $firstName = trim(postText('first_name'));
    $lastName = trim(postText('last_name'));
    $email = strtolower(trim(postText('email')));
    $password = postText('password');

    try {
        if (
            !filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($email) > 254
        ) {
            $error = 'Укажи корректный адрес электронной почты.';
        } elseif ($isLogin) {
            $query = $pdo->prepare(
                'SELECT id, password
                 FROM users
                 WHERE email = ?
                 LIMIT 1'
            );

            $query->execute([$email]);
            $user = $query->fetch();

            if ($user && $password === $user['password']) {
                signIn((int) $user['id']);
                redirectTo('index.php');
            } else {
                $error = 'Неверный email или пароль.';
            }
        } else {
            if (
                !preg_match('/\A.{1,100}\z/us', $firstName)
                || !preg_match('/\A.{1,100}\z/us', $lastName)
            ) {
                $error = 'Укажи имя и фамилию: до 100 символов в каждом поле.';
            } elseif (!preg_match('/\A.{8,128}\z/us', $password)) {
                $error = 'Пароль должен содержать от 8 до 128 символов.';
            } elseif (!preg_match('/[\p{P}\p{S}]/u', $password)) {
                $error = 'Добавь в пароль спецсимвол: например !, -, @ или #.';
            } else {
                $query = $pdo->prepare(
                    'INSERT INTO users (
                        first_name,
                        last_name,
                        email,
                        password,
                        role
                     )
                     VALUES (?, ?, ?, ?, ?)'
                );

                $query->execute([
                    $firstName,
                    $lastName,
                    $email,
                    $password,
                    'user',
                ]);

                signIn((int) $pdo->lastInsertId());
                redirectTo('profile.php');
            }
        }
    } catch (PDOException $exception) {
        if (
            !$isLogin
            && (int) ($exception->errorInfo[1] ?? 0) === 1062
        ) {
            $error = 'Пользователь с такой почтой уже имеется';
        } 
    }
}

$pageTitle = $isLogin ? 'Вход' : 'Регистрация';
$headerVariant = 'auth';

$extraCss = [
    'assets/css/categories.css',
    'assets/css/account.css',
];

require __DIR__ . '/includes/header.php';

?>

<main class="account-main">
    <div class="account-layout">
        <section class="account-welcome">

            <div>
                <h1>
                    <?= $isLogin
                        ? '#'
                        : '#' ?>
                </h1>

                <p>
                    <?= $isLogin
                        ? '#'
                        : '#' ?>
                </p>
            </div>

            <p class="account-caption">#</p>
        </section>

        <section class="account-form-panel">
            <h2>
                <?= $isLogin ? 'Авторизуйся' : 'Создать аккаунт' ?>
            </h2>

            <p class="account-description">
                <?= $isLogin
                    ? 'Введи email и пароль.'
                    : '' ?>
            </p>

            <?php if ($error): ?>
                <p class="account-error" role="alert">
                    <?= e($error) ?>
                </p>
            <?php endif; ?>

            <form
                class="account-form"
                method="post"
                action="<?= $isLogin
                    ? 'account.php?mode=login'
                    : 'account.php' ?>"
            >
                <?php csrfField(); ?>

                <?php if (!$isLogin): ?>
                    <div class="account-name-row">
                        <label>
                            Имя
                            <input
                                type="text"
                                name="first_name"
                                autocomplete="given-name"
                                maxlength="100"
                                value="<?= e($firstName) ?>"
                                required
                            >
                        </label>

                        <label>
                            Фамилия
                            <input
                                type="text"
                                name="last_name"
                                autocomplete="family-name"
                                maxlength="100"
                                value="<?= e($lastName) ?>"
                                required
                            >
                        </label>
                    </div>
                <?php endif; ?>

                <label>
                    Электронная почта
                    <input
                        type="email"
                        name="email"
                        autocomplete="email"
                        maxlength="254"
                        value="<?= e($email) ?>"
                        required
                    >
                </label>

                <label>
                    Пароль
                    <input
                        type="password"
                        name="password"
                        autocomplete="<?= $isLogin
                            ? 'current-password'
                            : 'new-password' ?>"
                        <?php if (!$isLogin): ?>
                            minlength="8"
                            maxlength="128"
                            pattern="(?=.*[\p{P}\p{S}]).{8,128}"
                            title="От 8 до 128 символов и минимум один спецсимвол"
                            aria-describedby="password-hint"
                        <?php endif; ?>
                        required
                    >
                </label>

                <?php if (!$isLogin): ?>
                    <p class="account-hint" id="password-hint">Пароль должен быть больше 8 символов и содержать 1 специальный знак</p>
                <?php endif; ?>

                <button type="submit" class="account-button">
                    <?= $isLogin ? 'Войти' : 'Зарегистрироваться' ?>
                </button>
            </form>

            <p class="account-switch">
                <?php if ($isLogin): ?>
                    Ещё нет аккаунта?
                    <a href="account.php">Зарегистрироваться</a>
                <?php else: ?>
                    Уже есть аккаунт?
                    <a href="account.php?mode=login">Войти</a>
                <?php endif; ?>
            </p>
        </section>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>