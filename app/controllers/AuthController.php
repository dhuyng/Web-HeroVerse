<?php
// app/controllers/AuthController.php
require_once('BaseController.php');
require_once(__DIR__ . '/../models/User.php');
class AuthController extends BaseController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            if ($this->validateRegistrationData($username, $email, $password)) {
                $userModel = new User();
                $result = $userModel->register($username, $email, $password);

                if ($result) {
                    header("Location: login");
                    exit();
                } else {
                    $_SESSION['error'] = "Registration failed!";
                    $this->render('register', 'Register - HeroVerse');
                }
            }
        } else {
            $this->render('register', 'Register - HeroVerse');
        }
    }

    private function validateRegistrationData($username, $email, $password) {
        // Add validation rules (e.g., check if username is already taken, etc.)
        return true;
    }
}
