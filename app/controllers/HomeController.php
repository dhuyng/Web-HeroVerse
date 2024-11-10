<?php

class HomeController {
    public function index() {
        $title = "Home - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/index.php";
        include "app/views/layouts/footer.php";
    }
    
    public function about() {
        $title = "About Us - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/about.php";
        include "app/views/layouts/footer.php";
    }

    public function heroes() {
        $title = "Heroes - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/heroes.php";
        include "app/views/layouts/footer.php";
    }

    public function maps() {
        $title = "Maps - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/maps.php";
        include "app/views/layouts/footer.php";
    }

    public function event() {
        $title = "Event - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/event.php";
        include "app/views/layouts/footer.php";
    }

    public function pricing() {
        $title = "Pricing - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/Pricing.php";
        include "app/views/layouts/footer.php";
    }


    public function contact() {
        $title = "Contact - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/contact.php";
        include "app/views/layouts/footer.php";
    }

    public function login() {
        $title = "Login - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/login.php";
        include "app/views/layouts/footer.php";
    }

    public function register() {
        $title = "Register - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/register.php";
        include "app/views/layouts/footer.php";
    }

    public function info() {
        $title = "Thông Tin Tài Khoản - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/user/info.php";
        include "app/views/layouts/footer.php";
    }

    public function balance() {
        $title = "Nạp Số Dư - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/user/balance.php";
        include "app/views/layouts/footer.php";
    }

    public function history() {
        $title = "Lịch Sử Giao Dịch - HeroVerse";
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/user/history.php";
        include "app/views/layouts/footer.php";
    }


  
}
