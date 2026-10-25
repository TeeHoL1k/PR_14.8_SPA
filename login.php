<?php
session_start();
require_once 'functions.php';

// Выход из системы
if (isset($_GET['logout'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['login']);
    unset($_SESSION['auth_time']);
    header('Location: login.php');
    exit;
}

// Если уже вошел — на главную
if (getCurrentUser() !== null) {
    header('Location: index.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? null;
    $password = $_POST['password'] ?? null;

    if (checkPassword($login, $password)) {
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $login;
        $_SESSION['auth_time'] = time(); // Записываем время входа

        header('Location: index.php');
        exit;
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <h1>Вход в систему</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="post">
        <input name="login" type="text" placeholder="Логин" required><br><br>
        <input name="password" type="password" placeholder="Пароль" required><br><br>
        <input name="submit" type="submit" value="Войти">
    </form>
</body>
</html>