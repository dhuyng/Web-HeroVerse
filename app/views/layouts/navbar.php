<?php
// app/views/layouts/navbar.php
// Kiểm tra trạng thái đăng nhập và quyền admin
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in']; // Giả sử người dùng đã đăng nhập
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'; // Giả sử người dùng là admin
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid bg-dark">
        <!-- Logo -->
        <a class="navbar-brand px-3" href="home">
            <img class="img-fluid" src="public/img/logo.png" alt="">
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
                    <li class="nav-item fw-bold"><a class="nav-link" href="home">Home</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="about">About</a></li>

                    <!-- GamePlay Dropdown -->
                    <li class="nav-item dropdown fw-bold">
                        <a class="nav-link dropdown-toggle" href="#" id="gameplayDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">GamePlay</a>
                        <ul class="dropdown-menu bg-dark p-0 m-0" aria-labelledby="gameplayDropdown">
                            <li>
                                <a class="dropdown-item bg-dark text-white nav-link" href="<?php echo $isLoggedIn ? 'heroes' : 'login'; ?>">Heroes</a>
                            </li>
                            <li>
                                <a class="dropdown-item bg-dark text-white nav-link" href="<?php echo $isLoggedIn ? 'maps' : 'login'; ?>">Maps</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item fw-bold"><a class="nav-link" href="event">Event</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="pricing">Pricing</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="contact">Contact</a></li>
                <?php else: ?>
                    <!-- Admin Navigation -->
                    <li class="nav-item fw-bold"><a class="nav-link" href="dashboard">Dashboard</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="user_mgmt">User Mgmt</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="gameplay_mgmt">GamePlay Mgmt</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="event_mgmt">Event Mgmt</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="support">Support</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Account Dropdown (Right Aligned) -->
        <div class="d-flex align-items-center">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                    $profilePicPath = 'public/img/avatar/' . $_SESSION['user']['profile_pic'];
                    $profilePicPath = (file_exists($profilePicPath) && $_SESSION['user']['profile_pic']) ? $profilePicPath : 'public/img/account.png';
                } else {
                    $profilePicPath = 'public/img/account.png';
                }
                ?>
                <img src="<?= $profilePicPath ?>" alt="Account" class="rounded-circle" width="40" height="40">
            </a>
            <ul class="dropdown-menu dropdown-menu-end bg-dark p-0 m-0" aria-labelledby="accountDropdown">
                <?php if ($isLoggedIn && !$isAdmin): ?>
                    <!-- Display when the user is logged in as a regular user -->
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="info">Thông tin tài khoản</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="balance">Nạp số dư</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="history">Lịch sử giao dịch</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="logout">Đăng xuất</a></li>
                </q><?php elseif ($isLoggedIn && $isAdmin): ?>
                    <!-- Display when the user is logged in as an admin -->
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="info_admin">Thông tin tài khoản</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="logout">Đăng xuất</a></li>
                <?php else: ?>
                    <!-- Display when the user is not logged in -->
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="login">Đăng nhập</a></li>
                    <li><a class="dropdown-item bg-dark text-white nav-link" href="register">Đăng ký</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
