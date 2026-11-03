<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/helpers.php';

$slug = trim((string) ($_GET['slug'] ?? ''));

$stmt = $pdo->prepare(
    'SELECT s.*, c.name AS category_name, c.slug AS category_slug, c.image AS category_image
     FROM subcategories s
     INNER JOIN categories c ON c.id = s.category_id
     WHERE s.slug = ?
     LIMIT 1'
);
$stmt->execute([$slug]);
$profession = $stmt->fetch();

if (!$profession) {
    http_response_code(404);
    $pageTitle = 'Профессия не найдена';
    $headerVariant = 'inner';
    $extraCss = ['assets/css/categories.css', 'assets/css/subcategory.css'];
    require __DIR__ . '/includes/header.php';
    echo '<main class="category-main"><h1>Профессия не найдена</h1></main>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$uniStmt = $pdo->prepare(
    'SELECT u.name
     FROM universities u
     INNER JOIN subcategory_universities su ON su.university_id = u.id
     WHERE su.subcategory_id = ?
     ORDER BY su.sort_order, u.name'
);
$uniStmt->execute([$profession['id']]);
$universities = $uniStmt->fetchAll(PDO::FETCH_COLUMN);

$collegeStmt = $pdo->prepare(
    'SELECT col.name
     FROM colleges col
     INNER JOIN subcategory_colleges sc ON sc.college_id = col.id
     WHERE sc.subcategory_id = ?
     ORDER BY sc.sort_order, col.name'
);
$collegeStmt->execute([$profession['id']]);
$colleges = $collegeStmt->fetchAll(PDO::FETCH_COLUMN);

$pageTitle = $profession['name'];
$headerVariant = 'inner';
$backHref = 'category.php?slug=' . $profession['category_slug'];
$backText = 'К категории ' . $profession['category_name'];
$searchValue = $profession['name'];
$extraCss = ['assets/css/categories.css', 'assets/css/subcategory.css'];
require __DIR__ . '/includes/header.php';
?>
    <main class="category-main subcategory-main">
        <h1><?php echo e($profession['name']); ?></h1>
        <p class="category-description"><?php echo e($profession['description']); ?></p>

        <h2 class="section-title">Места получения образования:</h2>

        <section class="edu-section">
            <h3 class="edu-heading">После 11 класса:</h3>
            <div class="edu-box">
                <?php render_name_list($universities, 'Вузы пока не добавлены.'); ?>
            </div>
            <p class="duration">Срок обучения: от 2 лет 10 месяцев до 4 лет</p>
        </section>

        <section class="edu-section edu-section-alt">
            <h3 class="edu-heading edu-heading-right">После 9 класса:</h3>
            <div class="edu-box edu-box-right">
                <?php render_name_list($colleges, 'Колледжи пока не добавлены.'); ?>
            </div>
            <p class="duration duration-right">Срок обучения: 3 года 10 месяцев</p>
        </section>

        <section class="bottom-actions">
            <div>
                <h3>Места практики:</h3>
                <?php if (!empty($profession['practice_url'])): ?>
                    <a class="pill-link" href="<?php echo e($profession['practice_url']); ?>" target="_blank" rel="noopener noreferrer">
                        <?php echo e($profession['practice_url']); ?>
                    </a>
                <?php else: ?>
                    <p class="empty-note">Ссылка на практику пока не указана.</p>
                <?php endif; ?>
            </div>
            <div>
                <h3>Трудоустройство:</h3>
                <a class="pill-link" href="anketa.php?slug=<?php echo e($profession['slug']); ?>">Заполнить анкету</a>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
