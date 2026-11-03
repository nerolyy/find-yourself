<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/helpers.php';

$categories = $pdo->query(
    'SELECT slug, name, image FROM categories ORDER BY sort_order, id'
)->fetchAll();

$pageTitle = 'FindYourself';
$headerVariant = 'main';
require __DIR__ . '/includes/header.php';
?>
    <main class="main">
        <aside class="sidebar">
            <h2>Помощь<br>в выборе профессии</h2>

            <div class="sidebar-menu">
                <button type="button" class="sidebar-button">
                    <img class="sidebar-icon" src="assets/images/test.png" alt="">
                    <span class="sidebar-text">Тест на профориентацию</span>
                    <span class="sidebar-arrow" aria-hidden="true">›</span>
                </button>

                <button type="button" class="sidebar-button">
                    <img class="sidebar-icon" src="assets/images/find.png" alt="">
                    <span class="sidebar-text">Подбор профессии по интересам</span>
                    <span class="sidebar-arrow" aria-hidden="true">›</span>
                </button>

                <button type="button" class="sidebar-button">
                    <img class="sidebar-icon" src="assets/images/proffesion.png" alt="">
                    <span class="sidebar-text">Профессии, которые сейчас востребованы</span>
                    <span class="sidebar-arrow" aria-hidden="true">›</span>
                </button>
            </div>
        </aside>

        <div class="content">
            <div class="intro">
                <p>
                    Одно из самых сложных решений в нашей жизни — это выбор того,
                    кем быть. Несомненно, в выборе профессии каждый человек должен
                    опираться на свои интересы, способности, склонности и желания.
                    Именно поэтому наш сайт предлагает свою помощь в решении
                    достаточно обширной проблемы: большое количество информации
                    расположено на разных интернет-ресурсах, что затрудняет
                    формирование полной картины тех сфер деятельности,
                    которые можно было бы выбрать.
                </p>
            </div>

            <section class="categories">
                <h1 class="categories-title">Категории профессий</h1>

                <div class="categories-grid">
                    <?php foreach ($categories as $category): ?>
                        <a href="category.php?slug=<?php echo e($category['slug']); ?>" class="category-card">
                            <img src="<?php echo e(asset($category['image'])); ?>" alt="">
                            <span><?php echo e($category['name']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
