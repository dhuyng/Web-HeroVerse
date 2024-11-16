<?php
// Gọi controller chính
require_once 'app/controllers/HomeController.php';
require_once 'config/tables_create.php';
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
