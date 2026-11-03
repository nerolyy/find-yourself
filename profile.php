<?php

require __DIR__ . '/includes/auth.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$user = requireUser();

$pageTitle = 'Мой профиль';
$headerVariant = 'inner';

$extraCss = [
    'assets/css/categories.css',
    'assets/css/account.css',
];

require __DIR__ . '/includes/header.php';

?>

<main class="account-main">
    <section class="profile-card">
        </span>

        <h1>Привет <?= e($user['first_name']) ?>!</h1>
            <p> Надеемся ты сможешь правильно определить свое будущее </p>
        <dl class="profile-details">
            <div>
                <dt>Имя</dt>
                <dd><?= e($user['first_name']) ?></dd>
            </div>

            <div>
                <dt>Фамилия</dt>
                <dd><?= e($user['last_name']) ?></dd>
            </div>

            <div>
                <dt>Электронная почта</dt>
                <dd><?= e($user['email']) ?></dd>
            </div>

            <div>
                <dt>Дата регистрации</dt>
                <dd>
                    <?= e(date('d.m.Y', strtotime($user['created_at']))) ?>
                </dd>
            </div>
        </dl>

        <div class="profile-actions">
            <a href="index.php" class="account-button">
                Смотреть профессии
            </a>

            <?php if ($user['role'] === 'admin'): ?>
                <a href="admin.php" class="account-button secondary">
                    Управление пользователями
                </a>
            <?php endif; ?>

            <form action="logout.php" method="post">
                <?php csrfField(); ?>

                <button type="submit" class="account-button secondary">
                    Выйти
                </button>
            </form>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>