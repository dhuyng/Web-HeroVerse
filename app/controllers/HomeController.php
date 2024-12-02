<?php
// app/controllers/HomeController.php
require_once('BaseController.php');
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
        // Generate Anti-CSRF token
        generateSessionToken();
        $this->render('login', 'Login - HeroVerse');
    }

    public function register() {
        $this->render('register', 'Register - HeroVerse');
    }

    public function info() {
        // Generate Anti-CSRF token
        generateSessionToken();
        $this->renderUser('info', 'Thông Tin Tài Khoản - HeroVerse');
    }

    public function balance() {
        $this->renderUser('balance', 'Nạp Số Dư - HeroVerse');
    }

    public function paymentResult() {
        $this->renderUser('paymentResult', 'Kết quả giao dịch - HeroVerse');
    }

    public function history() {
        $this->renderUser('history', 'Lịch Sử Giao Dịch - HeroVerse');
    }

    public function dragneel() {
        $this->renderHeroes('dragneel', 'Dragneel - HeroVerse');
    }

    public function dashboard() {
        $this->renderAdmin('dashboard', 'Dashboard - HeroVerse');
    }

    public function gameplay_mgmt() {
        $this->renderAdmin('gameplay_mgmt', 'Gameplay Management - HeroVerse');
    }

    public function event_mgmt() {
        $this->renderAdmin('event_mgmt', 'Event Management - HeroVerse');
    }

    public function user_mgmt() {
        $this->renderAdmin('user_mgmt', 'User Mangament - HeroVerse');
    }
    
    public function info_admin() {
        // Generate Anti-CSRF token
        generateSessionToken();
        $this->renderAdmin('info_admin', 'Info Admin - HeroVerse');
    }

    public function support() {
        $this->renderAdmin('support', 'Support - HeroVerse');
    }

    public function join_squad_event() {
        $this->render('event/join_squad_event', 'Join Squad Event - HeroVerse');
    }


}
