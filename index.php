<?php
// index.php
session_start();
// Security DVWA
require_once 'config/dvwaPage.inc.php';
// Check if it's an AJAX request by looking for the 'ajax' query parameter or the X-Requested-With header
$isAjaxRequest = isset($_GET['ajax']) || isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if ($isAjaxRequest) {
    // Redirect to the AJAX handler logic
    include 'app/controllers/ajaxHandler.php';
    exit();
}
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
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
require_once 'app/controllers/AuthController.php';
// require_once 'config/create_tables.php';
$url = $_GET['url'] ?? 'home'; // Lấy URL hoặc mặc định là 'home'

$controller = new HomeController();
$authController = new AuthController();

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
        require_once('app/controllers/EventController.php');
        $eventController = new EventController();
        $eventController->event();
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $authController->register();
        else $controller->register();
        break;
    case 'info':
        $controller->info();
        break;
    case 'balance':
        $controller->balance();
        break;
    case 'paymentResult':
        $controller->paymentResult();
        break;
    case 'history':
        $controller->history();
        break;
    case 'logout':
        $authController->logout();
        break;

    case 'Dragneel':
        $controller->dragneel();
        break;

    case 'dashboard':
        $controller->dashboard();
        break;

    case 'gameplay_mgmt':
        $controller->gameplay_mgmt();
        break;

    case 'event_mgmt':
        $controller->event_mgmt();
        break;

    case 'user_mgmt':
        $controller->user_mgmt();
        break;

    case 'info_admin':
        $controller->info_admin();
        break;
        
    case 'support':
        $controller->support();
        break;

    case 'event_item':
        require_once('app/controllers/EventController.php');
        $eventController = new EventController();
        $eventController->event_item();
        break;

    case 'join_squad_event':
        $controller->join_squad_event();
        break;


    default:
        $controller->index();
        break;
}
