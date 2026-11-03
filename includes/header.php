<?php
$pageTitle = $pageTitle ?? 'FindYourself';
$headerVariant = $headerVariant ?? 'main';
$backHref = $backHref ?? 'index.php';
$backText = $backText ?? 'Вернуться на главную';
$searchValue = $searchValue ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <?php if (!empty($extraCss)): ?>
        <?php foreach ((array) $extraCss as $cssFile): ?>
            <link rel="stylesheet" href="<?php echo e($cssFile); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
<?php if ($headerVariant === 'main'): ?>
    <header class="header">
        <a href="index.php" class="logo"><span>Find</span>Yourself</a>

        <form class="search" action="search.php" method="get">
            <input type="search" name="q" placeholder="Название профессии" aria-label="Название профессии" value="<?php echo e($searchValue); ?>">
            <button type="submit">Найти</button>
        </form>

        <div class="header-actions">
            <button type="button">Фильтры</button>
            <button type="button" aria-label="Личный кабинет">
                <img src="assets/images/reg.svg" alt="" width="26" height="26">
            </button>
        </div>
    </header>
<?php else: ?>
    <header class="category-header">
        <a href="index.php" class="logo"><span>Find</span>Yourself</a>

        <form class="search" action="search.php" method="get">
            <input type="search" name="q" placeholder="Название профессии" aria-label="Название профессии" value="<?php echo e($searchValue); ?>">
            <button type="submit">Найти</button>
        </form>

        <a href="<?php echo e($backHref); ?>" class="back-link"><?php echo e($backText); ?></a>
    </header>
<?php endif; ?>
