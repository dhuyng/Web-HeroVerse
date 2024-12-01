<?php
// app/controllers/BaseController.php
class BaseController {
    public function render($page, $title) {
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/{$page}.php";
        include "app/views/layouts/footer.php";
    }

    public function renderHeroes($heroes, $title) {
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/heroes/{$heroes}.php";
        include "app/views/layouts/footer.php";
    }

    public function renderUser($user, $title) {
        if (!isset($_SESSION['user'])) {
            header("Location: login");
            exit();
        }
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/user/{$user}.php";
        include "app/views/layouts/footer.php";
    }

    public function renderAdmin($admin, $title) {
        if (!isset($_SESSION['user'])) {
            header("Location: login");
            exit();
        }
        if ($_SESSION['user']['role'] !== 'admin') {
            echo "Unauthorized access.";
            exit();
        }
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/admin/{$admin}.php";
        include "app/views/layouts/footer.php";
    }

    public function renderEvent($template, $data = []) {
        extract($data);
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/event/{$template}.php";
        include "app/views/layouts/footer.php";
    }

    public function renderEventPage($page, $data = []) {
        extract($data);
        include "app/views/layouts/header.php";
        include "app/views/layouts/navbar.php";
        include "app/views/pages/{$page}.php";
        include "app/views/layouts/footer.php";
    }

}
