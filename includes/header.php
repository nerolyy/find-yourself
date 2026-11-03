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

    <title><?= e($pageTitle) ?></title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header-account.css">

    <?php if (!empty($extraCss)): ?>
        <?php foreach ((array) $extraCss as $cssFile): ?>
            <link rel="stylesheet" href="<?= e($cssFile) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
<?php if ($headerVariant === 'auth'): ?>
    <header class="category-header category-header-auth">
        <a href="index.php" class="logo">
            <span>Find</span>Yourself
        </a>
    </header>
<?php elseif ($headerVariant === 'main'): ?>
    <header class="header">
        <a href="index.php" class="logo">
            <span>Find</span>Yourself
        </a>

        <form class="search" action="search.php" method="get">
            <input
                type="search"
                name="q"
                placeholder="Название профессии"
                aria-label="Название профессии"
                value="<?= e($searchValue) ?>"
            >

            <button type="submit">Найти</button>
        </form>

        <div class="header-actions">
            <button type="button">Фильтры</button>

            <a
                href="profile.php"
                class="header-profile-link"
                aria-label="Личный кабинет"
            >
                <img
                    src="assets/images/reg.svg"
                    alt=""
                    width="26"
                    height="26"
                >
            </a>
        </div>
    </header>
<?php else: ?>
    <header class="category-header">
        <a href="index.php" class="logo">
            <span>Find</span>Yourself
        </a>

        <form class="search" action="search.php" method="get">
            <input
                type="search"
                name="q"
                placeholder="Название профессии"
                aria-label="Название профессии"
                value="<?= e($searchValue) ?>"
            >

            <button type="submit">Найти</button>
        </form>

        <a href="<?= e($backHref) ?>" class="back-link">
            <?= e($backText) ?>
        </a>
    </header>
<?php endif; ?>