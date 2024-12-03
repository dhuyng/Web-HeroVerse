<?php
header('Content-Type: application/json');

require_once 'app/controllers/AuthController.php';
$authController = new AuthController();
require_once 'app/controllers/TransactionController.php';
$transactionController = new TransactionController();
require_once 'app/controllers/EventController.php';
$eventController = new EventController();
require_once 'app/controllers/DashboardController.php';
$dashboardController = new DashboardController();
$ajaxAction = $_GET['ajax'] ?? '';

switch ($ajaxAction) {
    case 'login':
        $authController->login();
        break;
        
    case 'unlockAccount':
        $authController->unlockAccount();
        break;

    case 'verifyCurrentPassword':
        $authController->verifyCurrentPassword();
        break;
            
    case 'updateUserInfo':
        $authController->updateUserInfo();
        break;
            
    case 'updateAdminInfo':
        $authController->updateAdminInfo();
            break;

    case 'getTransactionHistory':
        $authController->getTransactionHistory();
        break;

    case 'generate_qr':
        $authController->generate_qr();
        break;

    case 'confirmTransaction':
        $transactionController->confirmTransaction();
        break;

    case 'momoGatewayCallbackHandler':
        $transactionController->momoGatewayCallbackHandler();
        break;

    case 'zaloPayGatewayCallbackHandler':
        $transactionController->zaloPayGatewayCallbackHandler();
        break;

    case 'momoGatewayCallbackHandlerResult':
        $transactionController->momoGatewayCallbackHandlerResult();
        break;

    case 'zaloPayGatewayCallbackHandlerResult':
        $transactionController->zaloPayGatewayCallbackHandlerResult();
        break;

    case 'getUserBalance':
        $transactionController->getUserBalance();
        break;
        
    case 'getAllUsers':
        $authController->userManager();
            break;

    case 'getAllSupports':
        $authController->getAllSupports();
            break;

    case 'deleteUser':
        $authController->deleteUser();
            break;
    
    case 'deleteSupport':
        $authController->deleteSupport();
            break;

    case 'toggleSupportStatus':
        error_log('toggleSupportStatus');
        $authController->toggleSupportStatus();
            break;

    case 'createEvent':
        $eventController->createEvent();
            break;

    case 'getEvents':
        $eventController->getEvents();
            break;

    case 'updateEvent':
        $eventController->updateEvent();
            break;

    case 'deleteEvent':
        $eventController->deleteEvent();
            break;

    case 'addComment':
        $eventController->addComment();
            break;

    case 'getComments':
        $eventController->getComments();
            break;
    case 'editComment':
        $eventController->editComment();
            break;
    case 'updateUser':
        $authController->updateUser();
            break;
    case 'countUsers':
        $dashboardController->countUsers();
            break;
    case 'countSupports':
        $dashboardController->countSupports();
            break;
    case 'countEvents':
        $dashboardController->countEvents();
            break;
    case 'usersByMonth':
        $dashboardController->countUserbyMonth();
            break;
    case 'coinForPayment':
        $dashboardController->coinForPayment();
            break;
    
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid AJAX action']);
        break;
}
exit;
