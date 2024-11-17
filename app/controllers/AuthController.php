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
            $role = trim($_POST['role']);
            
            if ($this->validateRegistrationData($username, $email, $password)) {
                $userModel = new User();
                $result = $userModel->register($username, $email, $password, $role);

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

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $userModel = new User();
            $user = $userModel->login($username, $password);

            if ($user) {
                // After successful login in the AuthController
                $_SESSION['user'] = $user;  // Store user data
                $_SESSION['logged_in'] = true;  // Indicate the user is logged in
                header("Location: home");
                exit();
            } else {
                $_SESSION['error'] = "Invalid username or password.";
                $this->render('login', 'Login - HeroVerse');
            }
        } else {
            $this->render('login', 'Login - HeroVerse');
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login");
        exit();
    }
}
