<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindYourself</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.php" class="logo"><span>Find</span>Yourself</a>

        <div class="search">
            <input type="search" placeholder="Название профессии" aria-label="Название профессии">
            <button type="button">Найти</button>
        </div>

        <div class="header-actions">
            <button type="button">Фильтры</button>

            <button type="button" aria-label="Личный кабинет">
                <img src="assets/images/reg.svg" alt="" width="26" height="26">
            </button>
        </div>
    </header>

    <main class="main">
        <aside class="sidebar">
    <h2>Помощь<br>в выборе профессии</h2>

    <div class="sidebar-menu">
        <button type="button" class="sidebar-button">
            <img class="sidebar-icon" src="#" alt="" >
            <span class="sidebar-text">Тест на профориентацию</span>
            <span class="sidebar-arrow" aria-hidden="true">›</span>
        </button>

        <button type="button" class="sidebar-button">
            <img class="sidebar-icon" src="assets/images/interests.svg" alt="">
            <span class="sidebar-text">Подбор профессии по интересам</span>
            <span class="sidebar-arrow" aria-hidden="true">›</span>
        </button>

        <button type="button" class="sidebar-button">
            <img class="sidebar-icon" src="assets/images/proffesion.png" alt="">
            <span class="sidebar-text">
                Профессии, которые сейчас востребованы
            </span>
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
                    <a href="categories/it.php" class="category-card">
                    <img src="assets/images/it.png" alt="">
                    <span>IT</span>
                    </a>
                    </button>

                    <button type="button" class="category-card">
                        <img src="assets/images/economic.png" alt="">
                        <span>Экономика</span>
                    </button>

                    <button type="button" class="category-card">
                        <img src="assets/images/torg.png" alt="">
                        <span>Торговля</span>
                    </button>

                    <button type="button" class="category-card">
                        <img src="assets/images/medicine.png" alt="">
                        <span>Медицина</span>
                    </button>

                    <button type="button" class="category-card">
                        <img src="assets/images/style.png" alt="">
                        <span>Мода</span>
                    </button>

                    <button type="button" class="category-card">
                        <img src="assets/images/science.png" alt="">
                        <span>Наука</span>
                    </button>

                    <button type="button" class="category-card">
                        <img src="assets/images/sport.png" alt="">
                        <span>Спорт</span>
                    </button>

                    <button type="button" class="category-card">
                        <img src="assets/images/marketing.png" alt="">
                        <span>Маркетинг</span>
                    </button>

                    <button type="button" class="category-card">
                        <img src="assets/images/tourism.png" alt="">
                        <span>Туризм</span>
                    </button>
                </div>
            </section>
        </div>
    </main>
</body>
</html>