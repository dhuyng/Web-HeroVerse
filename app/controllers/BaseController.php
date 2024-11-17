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