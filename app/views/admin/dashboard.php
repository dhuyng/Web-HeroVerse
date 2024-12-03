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
                        <h5 class="card-title text-white fw-bold">Sự kiện đang hoạt động</h5>
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
    <!-- <div class="card mt-4 shadow">
        <div class="card-body">
            <h4 class="card-title text-white fww-bold text-secondary">Thống Kê Người Dùng</h4>
            <canvas id="userChart" width="400" height="200"></canvas>
        </div>
    </div> -->


    <div class="card mt-4 shadow">
        <div class="card-body">
            <h4 class="card-title text-secondary fw-bold">Thống Kê Người Dùng</h4>
            <div class="row">
                <div class="col-md-6 mb-8 d-flex justify-content-center">
                    <canvas id="chartNewUsers" width="800" height="400"></canvas>
                </div>
                <div class="col-md-6 mb-8 d-flex justify-content-center">
                    <canvas id="coinForPayment"></canvas>
                </div>
            </div>
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
        <a href="user_mgmt" class="btn btn-outline-primary me-2">Quản Lý Người Dùng</a>
        <a href="content_mgmt" class="btn btn-outline-secondary me-2">Quản Lý Nội Dung</a>
        <a href="support" class="btn btn-outline-danger">Xem biểu mẫu User</a>
    </div>
</div>

<!-- Tích hợp Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // Lấy dữ liệu từ server
    fetch('index.php?ajax=countUsers', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success'){
            document.getElementById('totalUsers').textContent = data.data;
        }
        else {
            console.error(data.message);
        }
    });

    fetch('index.php?ajax=countSupports', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success'){
            document.getElementById('pendingRequests').textContent = data.data;
        }
        else {
            console.error(data.message);
        }
    });

    fetch('index.php?ajax=countEvents', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success'){
            document.getElementById('activeResources').textContent = data.data;
        }
        else {
            console.error(data.message);
        }
    });
});
    
</script>






<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch data via AJAX
    function fetchChartData(endpoint, callback) {
        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    callback(data.data);
                } else {
                    console.error(data.message);
                }
            });
    }

    // Chart configurations
    const chartConfigs = [
        { id: 'chartNewUsers', type: 'line',label: 'Người dùng mới', endpoint: 'index.php?ajax=usersByMonth' },
        { id: 'coinForPayment', type: 'pie',label: 'Tổng coin từng payment', endpoint: 'index.php?ajax=coinForPayment' }
        // { id: 'chartChurnedUsers', type: '',label: 'Người dùng rời bỏ', endpoint: 'index.php?ajax=churnedUsersByMonth' },
        // { id: 'chartMonthlyRevenue', type: '',label: 'Doanh thu hàng tháng', endpoint: 'index.php?ajax=revenueByMonth' }
    ];

    fetchChartData(chartConfigs[0].endpoint, function (data) {
        const ctx = document.getElementById(chartConfigs[0].id).getContext('2d');
        new Chart(ctx, {
            type: chartConfigs[0].type,
            data: {
                labels: data.labels,
                datasets: [{
                    label: chartConfigs[0].label,
                    data: data.values,
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
    })

fetchChartData(chartConfigs[1].endpoint, function (data) {
    const canvas = document.getElementById(chartConfigs[1].id);
    const ctx = canvas.getContext('2d');

    // Set the resolution and display size dynamically
    const displayWidth = 400; // Fixed width for display
    const displayHeight = 400; // Fixed height for display
    canvas.width = displayWidth; // Intrinsic resolution
    canvas.height = displayHeight; // Intrinsic resolution
    canvas.style.width = `${displayWidth}px`; // CSS width
    canvas.style.height = `${displayHeight}px`; // CSS height

    if (!data.values || data.values.length === 0) {
        console.error('No data available for the pie chart.');
        return;
    }

    const total = data.values.reduce((sum, value) => sum + value, 0);
    const percentages = data.values.map(value => ((value / total) * 100).toFixed(2));

    new Chart(ctx, {
        type: chartConfigs[1].type,
        data: {
            labels: data.labels,
            datasets: [{
                label: chartConfigs[1].label,
                data: data.values,
                backgroundColor: [
                    'rgba(128, 0  , 128, 1)',
                    'rgba(25 , 135, 84 , 1)',
                    'rgba(220, 53 , 69 , 1)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Disable responsiveness for fixed dimensions
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const index = context.dataIndex;
                            return `${context.label}: ${context.raw} coins (${percentages[index]}%)`;
                        }
                    }
                }
            }
        }
    });
});

});

</script>
