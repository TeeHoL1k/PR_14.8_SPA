<?php
session_start();
require_once 'functions.php';

$currentUser = getCurrentUser();
$timer = getTimerRemaining();
$birthdayInfo = getBirthdayInfo();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA-Салон Фонтан</title>
</head>
<body>
    <div>
        <header style="display: flex; justify-content: space-between; align-items: center; background: #eee; padding: 10px 20px;">
            <h1>СПА-салон Фонтан</h1>
            <div>
                <?php if ($currentUser): ?>
                    <span>Привет, <strong><?= htmlspecialchars($currentUser) ?></strong>!</span>
                    <a href="login.php?logout=true" style="margin-left: 15px;">Выйти</a>
                <?php else: ?>
                    <a href="login.php">Войти</a>
                <?php endif; ?>
            </div>
        </header>

        <?php if ($currentUser && $timer): ?>
            <div style="background: #eef; padding: 15px; margin: 20px 0; border-radius: 5px;">
                <h3>Индивидуальная акция!</h3>
                <p>До окончания персональной скидки осталось: <strong><?= $timer ?></strong></p>
            </div>
        <?php endif; ?>

        <?php if ($currentUser && $birthdayInfo): ?>
            <div style="background: #fee; padding: 15px; margin: 20px 0; border-radius: 5px;">
                <p><strong><?= $birthdayInfo ?></strong></p>
            </div>
        <?php endif; ?>

        <section id="gallery">
            <h2>Наш салон</h2>
            <div class="gallery-images" style="display:flex; gap:20px; margin-bottom: 30px; justify-content: center;">
                <img src="img/foto_1.jpg" alt="Уход" style="width: 30%; border-radius: 8px;">
                <img src="img/foto_2.jpg" alt="Массаж" style="width: 30%; border-radius: 8px;">
                <img src="img/foto_3.jpg" alt="Косметология" style="width: 30%; border-radius: 8px;">
            </div>
        </section>

        <section id="services">
            <h2>Наши услуги</h2>
            <ul style="text-align: left; background: #f9f9f9; padding: 20px; border-radius: 8px;">
                <li>Классический массаж — 1500 руб.</li>
                <li>Уход за кожей лица — 2000 руб.</li>
                <li>Ароматерапия — 1000 руб.</li>
            </ul>
        </section>

        <section id="promotions">
            <h2>Актуальные акции</h2>
            <ul>
                <li>Счастливые часы: скидка 20% по будням с 10:00 до 14:00.</li>
                <li>Приведи друга и получи скидку 10% на следующий сеанс массажа.</li>
            </ul>
        </section>
    </div>
</body>
</html>