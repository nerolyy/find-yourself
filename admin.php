<?php

require __DIR__ . '/includes/auth.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$admin = requireAdmin();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();

    $userId = filter_var(
        postText('user_id'),
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    $role = postText('role');

    if (!$userId || !in_array($role, ['user', 'moderator'], true)) {
        $error = 'Некорректные данные.';
    } else {
        try {
            $query = $pdo->prepare(
                "UPDATE users
                 SET role = ?
                 WHERE id = ?
                   AND role <> 'admin'"
            );

            $query->execute([$role, $userId]);

            redirectTo('admin.php');
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $error = 'Не удалось сохранить роль.';
        }
    }
}

$users = $pdo->query(
    'SELECT id, first_name, last_name, email, role
     FROM users
     ORDER BY id DESC'
)->fetchAll();

$pageTitle = 'Управление пользователями';
$headerVariant = 'inner';
$backHref = 'profile.php';
$backText = 'В профиль';

$extraCss = [
    'assets/css/categories.css',
    'assets/css/account.css',
];

require __DIR__ . '/includes/header.php';

?>

<main class="account-main">
    <section class="admin-card">
        <h1>Управление пользователями</h1>

        <p class="account-description">
            Назначай модераторов и управляй их доступом.
        </p>

        <?php if ($error): ?>
            <p class="account-error" role="alert">
                <?= e($error) ?>
            </p>
        <?php endif; ?>

        <div class="users-table-wrap">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Имя и фамилия</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Управление</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $item): ?>
                        <tr>
                            <td>
                                <?= e($item['first_name']) ?>
                                <?= e($item['last_name']) ?>
                            </td>

                            <td><?= e($item['email']) ?></td>

                            <td><?= e(roleName($item['role'])) ?></td>

                            <td>
                                <?php if ($item['role'] !== 'admin'): ?>
                                    <form method="post" class="role-form">
                                        <?php csrfField(); ?>

                                        <input
                                            type="hidden"
                                            name="user_id"
                                            value="<?= (int) $item['id'] ?>"
                                        >

                                        <select
                                            name="role"
                                            aria-label="Роль пользователя"
                                        >
                                            <option
                                                value="user"
                                                <?= $item['role'] === 'user'
                                                    ? 'selected' : '' ?>
                                            >
                                                Пользователь
                                            </option>

                                            <option
                                                value="moderator"
                                                <?= $item['role'] === 'moderator'
                                                    ? 'selected' : '' ?>
                                            >
                                                Модератор
                                            </option>
                                        </select>

                                        <button
                                            type="submit"
                                            class="account-button"
                                        >
                                            Сохранить
                                        </button>
                                    </form>
                                <?php else: ?>
                                    Администратор
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>