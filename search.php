<?php
require __DIR__ . '/includes/db.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$q = trim((string) ($_GET['q'] ?? ''));
$results = [];

if ($q !== '') {
    $stmt = $pdo->prepare(
        'SELECT s.slug, s.name, s.description, c.name AS category_name
         FROM subcategories s
         INNER JOIN categories c ON c.id = s.category_id
         WHERE s.name LIKE ? OR s.description LIKE ?
         ORDER BY s.name'
    );
    $like = '%' . $q . '%';
    $stmt->execute([$like, $like]);
    $results = $stmt->fetchAll();
}

$pageTitle = 'Поиск профессии';
$headerVariant = 'inner';
$searchValue = $q;
$extraCss = ['assets/css/categories.css'];
require __DIR__ . '/includes/header.php';
?>
    <main class="category-main">
        <h1>Поиск</h1>
        <?php if ($q === ''): ?>
            <p class="category-description">Введите название профессии в строке поиска.</p>
        <?php elseif (!$results): ?>
            <p class="category-description">Ничего не найдено по запросу «<?php echo e($q); ?>».</p>
        <?php else: ?>
            <p class="category-description">Найдено: <?php echo count($results); ?></p>
            <div class="professions-grid">
                <?php foreach ($results as $item): ?>
                    <a class="profession-card" href="subcategory.php?slug=<?php echo e($item['slug']); ?>">
                        <h2><?php echo e($item['name']); ?></h2>
                        <p><?php echo e($item['category_name']); ?>. <?php echo e($item['description']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
