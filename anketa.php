<?php
require __DIR__ . '/includes/db.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$slug = trim((string) ($_GET['slug'] ?? ''));
$professionName = '';

if ($slug !== '') {
    $stmt = $pdo->prepare('SELECT name FROM subcategories WHERE slug = ? LIMIT 1');
    $stmt->execute([$slug]);
    $professionName = (string) $stmt->fetchColumn();
}

$sent = $_SERVER['REQUEST_METHOD'] === 'POST';

$pageTitle = 'Анкета на трудоустройство';
$headerVariant = 'inner';
$backHref = $slug !== '' ? 'subcategory.php?slug=' . $slug : 'index.php';
$backText = 'Назад';
$extraCss = ['assets/css/categories.css', 'assets/css/subcategory.css'];
require __DIR__ . '/includes/header.php';
?>
    <main class="category-main">
        <h1>Анкета на трудоустройство</h1>
        <?php if ($professionName): ?>
            <p class="category-description">Профессия: <?php echo e($professionName); ?></p>
        <?php endif; ?>

        <?php if ($sent): ?>
            <p class="category-description">Спасибо! Анкета отправлена, с вами свяжутся позже.</p>
        <?php else: ?>
            <form class="anketa-form" method="post">
                <label>
                    Имя
                    <input type="text" name="name" required>
                </label>
                <label>
                    Email
                    <input type="email" name="email" required>
                </label>
                <label>
                    Комментарий
                    <textarea name="comment" rows="4"></textarea>
                </label>
                <button type="submit" class="pill-link anketa-submit">Отправить</button>
            </form>
        <?php endif; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
