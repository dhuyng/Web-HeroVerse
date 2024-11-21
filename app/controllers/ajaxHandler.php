<?php
header('Content-Type: application/json');

require_once 'app/controllers/AuthController.php';
$authController = new AuthController();
$ajaxAction = $_GET['ajax'] ?? '';

switch ($ajaxAction) {
    case 'verifyCurrentPassword':
        $authController->verifyCurrentPassword();
            break;
            
    case 'updateUserInfo':
        $authController->updateUserInfo();
            break;
            
    case 'updateAdminInfo':
        $authController->updateAdminInfo();
            break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid AJAX action']);
        break;
}
exit;