<?php
// process.php
session_start();
require_once 'ApiClient.php';

$name = htmlspecialchars($_POST['customerName'] ?? '');
$quantity = (int)($_POST['quantity'] ?? 0);
$restaurant = htmlspecialchars($_POST['restaurant'] ?? '');
$packaging = htmlspecialchars($_POST['packaging'] ?? '');
$onlinePay = isset($_POST['onlinePay']) ? 'Да' : 'Нет';

$cacheFile = 'api_cache.json';
$cacheTtl = 300;
$apiData = null;

// Логика кеширования (такая же, как в refresh)
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTtl)) {
    $apiData = json_decode(file_get_contents($cacheFile), true);
} else {
    $api = new ApiClient();
    $apiData = $api->request('https://www.themealdb.com/api/json/v1/1/random.php');
    if ($apiData && !isset($apiData['error'])) {
        file_put_contents($cacheFile, json_encode($apiData, JSON_UNESCAPED_UNICODE));
    }
}

$_SESSION['api_data'] = $apiData;

// Валидация
$errors = [];
if (empty($name)) $errors[] = "Укажите имя заказчика";
if ($quantity <= 0) $errors[] = "Количество блюд должно быть больше 0";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

// Сессия и Куки
$_SESSION['last_order'] = ['name' => $name, 'quantity' => $quantity, 'restaurant' => $restaurant];
setcookie("user_name", $name, time() + 3600, "/");
setcookie("last_order_time", date('Y-m-d H:i:s'), time() + 3600, "/");

// Запись в файл
$line = "$name|$quantity|$restaurant|$packaging|$onlinePay" . PHP_EOL;
file_put_contents("data.txt", $line, FILE_APPEND);

header("Location: index.php");
exit();