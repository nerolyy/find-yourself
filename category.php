<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/helpers.php';

$slug = trim((string) ($_GET['slug'] ?? ''));

$stmt = $pdo->prepare('SELECT * FROM categories WHERE slug = ? LIMIT 1');
$stmt->execute([$slug]);
$category = $stmt->fetch();

if (!$category) {
    http_response_code(404);
    $pageTitle = 'Категория не найдена';
    $headerVariant = 'inner';
    $extraCss = ['assets/css/categories.css'];
    require __DIR__ . '/includes/header.php';
    echo '<main class="category-main"><h1>Категория не найдена</h1></main>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$stmt = $pdo->prepare(
    'SELECT slug, name, description, image
     FROM subcategories
     WHERE category_id = ?
     ORDER BY sort_order, id'
);
$stmt->execute([$category['id']]);
$subcategories = $stmt->fetchAll();

$pageTitle = $category['name'] . ' профессии';
$headerVariant = 'inner';
$extraCss = ['assets/css/categories.css'];
require __DIR__ . '/includes/header.php';
?>
    <main class="category-main">
        <h1><?php echo e($category['name']); ?> профессии</h1>
        <p class="category-description"><?php echo e($category['description']); ?></p>

        <div class="professions-grid">
            <?php foreach ($subcategories as $item): ?>
                <a class="profession-card" href="subcategory.php?slug=<?php echo e($item['slug']); ?>">
                    <img src="<?php echo e(asset($item['image'] ?: $category['image'])); ?>" alt="">
                    <h2><?php echo e($item['name']); ?></h2>
                    <p><?php echo e($item['description']); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
