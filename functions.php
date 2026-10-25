<?php

require_once 'users.php';

// Возвращает массив всех пользователей и хэшей их паролей
function getUsersList() {
    global $users;
    return $users;
}

// Проверяет, существует ли пользователь с указанным логином
function existsUser($login) {
    $usersList = getUsersList();
    return array_key_exists($login, $usersList);
}

// Проверяет правильность пароля
function checkPassword($login, $password) {
    if (existsUser($login)) {
        $usersList = getUsersList();
        $hash = $usersList[$login]['password'];

        return password_verify($password, $hash);
    }

    return false;
}

// Возвращает либо имя вошедшего на сайт пользователя, либо null
function getCurrentUser() {
    return $_SESSION['login'] ?? null;
}

// Получить данные текущего пользователя из массива
function getCurrentUserData() {
    $login = getCurrentUser();
    if ($login) {
        $usersList = getUsersList();
        return $usersList[$login] ?? null;
    }
    return null;
}

// Расчет таймера персональной акции (24 часа от входа)
function getTimerRemaining() {
    if (!isset($_SESSION['auth_time'])) {
        return null;
    }

    $elapsedTime = time() - $_SESSION['auth_time'];
    $totalTime = 24 * 60 * 60; // 24 часа в секундах
    $remainingTime = $totalTime - $elapsedTime;

    if ($remainingTime <= 0) {
        return "Акция завершена";
    }

    $hours = floor($remainingTime / 3600);
    $minutes = floor(($remainingTime % 3600) / 60);
    $seconds = $remainingTime % 60;

    return sprintf("%02d ч. %02d мин. %02d сек.", $hours, $minutes, $seconds);
}

// Расчет дней до дня рождения или поздравление
function getBirthdayInfo() {
    $userData = getCurrentUserData();
    if (!$userData || empty($userData['birthday'])) {
        return "";
    }

    $today = new DateTime('today');
    $birthday = new DateTime($today->format('Y') . '-' . date('m-d', strtotime($userData['birthday'])));

    if ($today > $birthday) {
        $birthday->modify('+1 year');
    }

    $interval = $today->diff($birthday);
    $days = $interval->days;

    if ($days === 0) {
        return "🎉 С днем рождения! Сегодня для вас действует персональная скидка 5% на все услуги салона!";
    } else {
        return "До вашего дня рождения осталось дней: {$days}.";
    }
}