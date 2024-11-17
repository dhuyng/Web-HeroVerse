<?php
// app/controllers/BaseController.php
class BaseController {
    public function render($page, $title) {
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/{$page}.php";
        include "app/views/layouts/footer.php";
    }
}

// app/controllers/HomeController.php
class HomeController extends BaseController {
    public function index() {
        $this->render('index', 'Home - HeroVerse');
    }
    
    public function about() {
        $this->render('about', 'About Us - HeroVerse');
    }

    public function heroes() {
        $this->render('heroes', 'Heroes - HeroVerse');
    }

    public function maps() {
        $this->render('maps', 'Maps - HeroVerse');
    }

    public function event() {
        $this->render('event', 'Event - HeroVerse');
    }

    public function pricing() {
        $this->render('Pricing', 'Pricing - HeroVerse');
    }

    public function contact() {
        $this->render('contact', 'Contact - HeroVerse');
    }

    public function login() {
        $this->render('login', 'Login - HeroVerse');
    }

    public function register() {
        $this->render('register', 'Register - HeroVerse');
    }

    public function info() {
        $this->render('user/info', 'Thông Tin Tài Khoản - HeroVerse');
    }

    public function balance() {
        $this->render('user/balance', 'Nạp Số Dư - HeroVerse');
    }

    public function history() {
        $this->render('user/history', 'Lịch Sử Giao Dịch - HeroVerse');
    }
}
