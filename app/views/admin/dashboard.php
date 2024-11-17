<?php
// session_start();
// Kiểm tra nếu người dùng chưa đăng nhập hoặc không phải admin, chuyển hướng đến trang đăng nhập
// if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
//     header("Location: login");
//     exit;
// }

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/navbar.php';
?>

<div class="container mt-5">
    <!-- Header Dashboard -->
    <div class="text-center mb-4">
        <h2 class="text-center text-primary">DASHBOARD</h2>
        <p>Quản lý người dùng, nội dung và hỗ trợ các yêu cầu của người dùng</p>
    </div>

    <!-- Thống kê chính -->
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3 shadow d-flex flex-column justify-content-between">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white fw-bold">Tổng số người dùng</h5>
                        <p class="card-text fw-bold" id="totalUsers">123</p> <!-- Cập nhật động -->
                    </div>
                    <i class="bi bi-person-fill fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3 shadow d-flex flex-column justify-content-between">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white fw-bold">Tài nguyên đang hoạt động</h5>
                        <p class="card-text fw-bold" id="activeResources">456</p> <!-- Cập nhật động -->
                    </div>
                    <i class="bi bi-gear-fill fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3 shadow d-flex flex-column justify-content-between">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white fw-bold">Yêu cầu chưa được xử lý</h5>
                        <p class="card-text fw-bold" id="pendingRequests">10</p> <!-- Cập nhật động -->
                    </div>
                    <i class="bi bi-exclamation-circle-fill fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ với Chart.js -->
    <div class="card mt-4 shadow">
        <div class="card-body">
            <h4 class="card-title text-white fww-bold text-secondary">Thống Kê Người Dùng</h4>
            <canvas id="userChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Tóm tắt nhanh -->
    <div class="card mt-4 shadow">
        <div class="card-body">
            <h4 class="card-title text-white fww-bold text-secondary">Hoạt Động Gần Đây</h4>
            <ul class="list-group">
                <li class="list-group-item">Người dùng <strong>dragneel_user</strong> đã nạp 20 Coin.</li>
                <li class="list-group-item">Nội dung mới đã được phê duyệt.</li>
                <li class="list-group-item">Báo cáo từ người dùng <strong>user123</strong> đang chờ xử lý.</li>
                <!-- Thêm các hoạt động khác -->
            </ul>
        </div>
    </div>

    <!-- Các liên kết quản lý -->
    <div class="mt-4">
        <h5 class="fw-bold">Truy cập nhanh:</h5>
        <a href="app/views/admin/user_mgmt.php" class="btn btn-outline-primary me-2">Quản Lý Người Dùng</a>
        <a href="app/views/admin/content_mgmt.php" class="btn btn-outline-secondary me-2">Quản Lý Nội Dung</a>
        <a href="app/views/admin/support.php" class="btn btn-outline-danger">Xem biểu mẫu User</a>
    </div>
</div>

<!-- Tích hợp Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ người dùng
    var ctx = document.getElementById('userChart').getContext('2d');
    var userChart = new Chart(ctx, {
        type: 'line', // hoặc 'bar', 'pie', vv.
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
            datasets: [{
                label: 'Người dùng mới',
                data: [12, 19, 3, 5, 2],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
