<?php
// index.php
// Setting up the base URL dynamically
$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= $baseUrl; ?>" />
</head>

<?php
 
// Gọi controller chính
require_once 'app/controllers/HomeController.php';
require_once 'config/create_tables.php';
$url = $_GET['url'] ?? 'home'; // Lấy URL hoặc mặc định là 'home'

$controller = new HomeController();

switch ($url) {
    case 'about':
        $controller->about();
        break;
    case 'heroes':
        $controller->heroes();
        break;
    case 'maps':
        $controller->maps();
        break;
    case 'event':
        $controller->event();
        break;
    case 'pricing':
        $controller->pricing();
        break;
    case 'contact':
        $controller->contact();
        break;
    case 'login':
        $controller->login();
        break;
    case 'register':
        $controller->register();
        break;
    case 'info':
        $controller->info();
        break;
    case 'balance':
        $controller->balance();
        break;
    case 'history':
        $controller->history();
        break;
    default:
        $controller->index();
        break;
}
