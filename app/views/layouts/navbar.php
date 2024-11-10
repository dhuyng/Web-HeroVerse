<?php
// Kiểm tra trạng thái đăng nhập và quyền admin
$isLoggedIn = false; // Giả sử người dùng đã đăng nhập
$isAdmin = false; // Giả sử người dùng là admin
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid bg-dark">
        <!-- Logo -->
        <a class="navbar-brand px-3" href="/HeroVerse/home">
            <img class="img-fluid" src="/HeroVerse/public/img/logo.png" alt="">
        </a>

        <!-- Toggle Button for Small Screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Centered Nav Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (!$isAdmin): ?>
                    <!-- General User Navigation -->
                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/home">Home</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/about">About</a></li>

                    <!-- GamePlay Dropdown -->
                    <li class="nav-item dropdown fw-bold">
                        <a class="nav-link dropdown-toggle" href="#" id="gameplayDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">GamePlay</a>
                        <ul class="dropdown-menu bg-dark p-0 m-0" aria-labelledby="gameplayDropdown">
                            <li>
                                <a class="dropdown-item bg-dark text-white nav-link" href="<?php echo $isLoggedIn ? '/HeroVerse/heroes' : '/HeroVerse/login'; ?>">Heroes</a>
                            </li>
                            <li>
                                <a class="dropdown-item bg-dark text-white nav-link" href="<?php echo $isLoggedIn ? '/HeroVerse/maps' : '/HeroVerse/login'; ?>">Maps</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/event">Event</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/pricing">Pricing</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/contact">Contact</a></li>
                <?php else: ?>
                    <!-- Admin Navigation -->
                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/app/views/admin/dashboard.php">Dashboard</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/app/views/admin/user_mgmt.php">User Mgmt</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/app/views/admin/content_mgmt.php">Content Mgmt</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="/HeroVerse/app/views/admin/support.php">Support</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Account Dropdown (Right Aligned) -->
        <div class="d-flex align-items-center">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/HeroVerse/public/img/account.png" alt="Account" class="rounded-circle" width="40" height="40">
            </a>
            <ul class="dropdown-menu dropdown-menu-end bg-dark p-0 m-0" aria-labelledby="accountDropdown">
                <?php if ($isLoggedIn && !$isAdmin): ?>
                    <!-- Display when the user is logged in as a regular user -->
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="/HeroVerse/info">Thông tin tài khoản</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="/HeroVerse/balance">Nạp số dư</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="/HeroVerse/history">Lịch sử giao dịch</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="views/logout">Đăng xuất</a></li>
                </q><?php elseif ($isLoggedIn && $isAdmin): ?>
                    <!-- Display when the user is logged in as an admin -->
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="/HeroVerse/app/views/admin/info_admin.php">Thông tin tài khoản</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="views/logout">Đăng xuất</a></li>
                <?php else: ?>
                    <!-- Display when the user is not logged in -->
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="/HeroVerse/login">Đăng nhập</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="/HeroVerse/register">Đăng ký</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
