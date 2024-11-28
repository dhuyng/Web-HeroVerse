<div class="container mt-5 wow fadeInUp" data-wow-duration="1.5s">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h3 class="card-title text-center mb-4 text-primary">Lịch Sử Giao Dịch</h3>

            <!-- Lịch sử giao dịch đã nạp -->
            <h5 class="mb-3 text-success">Lịch Sử Nạp</h5>
            <table class="table table-bordered mb-4">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Mã đơn</th>
                        <th scope="col">Ngày</th>
                        <th scope="col">Số tiền</th>
                        <th scope="col">Số Coin nhận được</th>
                        <th scope="col">Phương thức thanh toán</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Nội dung giao dịch</th>
                    </tr>
                </thead>
                <tbody id="recharge-history">
                    <!-- Recharge history will be populated dynamically -->
                </tbody>
            </table>

            <!-- Lịch sử giao dịch đã sử dụng -->
            <h5 class="mb-3 text-danger">Lịch Sử Sử Dụng</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Ngày</th>
                        <th scope="col">Số Coin đã dùng</th>
                        <th scope="col">Nội dung giao dịch</th>
                    </tr>
                </thead>
                <tbody id="usage-history">
                    <!-- Usage history will be populated dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('index.php?ajax=getTransactionHistory', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const rechargeTableBody = document.getElementById('recharge-history');
                const usageTableBody = document.getElementById('usage-history');

                // Populate Recharge History
                if (data.data.recharges.length > 0) {
                    data.data.recharges.forEach(recharge => {
                        const statusClass = {
                            pending: "text-warning",
                            completed: "text-success",
                            failed: "text-danger"
                        }[recharge.status.toLowerCase()];

                        rechargeTableBody.innerHTML += `
                            <tr>
                                <td>${recharge.orderId}</td>
                                <td>${new Date(recharge.date).toLocaleDateString()}</td>
                                <td>${parseFloat(recharge.amount).toLocaleString('vi-VN')} đ</td>
                                <td>${recharge.coins} Coin</td>
                                <td>${recharge.payment_method.charAt(0).toUpperCase() + recharge.payment_method.slice(1)}</td>
                                <td class="${statusClass}">${recharge.status.charAt(0).toUpperCase() + recharge.status.slice(1)}</td>
                                <td>${recharge.description}</td>
                            </tr>`;
                    });
                } else {
                    rechargeTableBody.innerHTML = '<tr><td colspan="4" class="text-center">Không có lịch sử nạp</td></tr>';
                }

                // Populate Usage History
                if (data.data.usages.length > 0) {
                    data.data.usages.forEach(usage => {
                        usageTableBody.innerHTML += `
                            <tr>
                                <td>${new Date(usage.date).toLocaleDateString()}</td>
                                <td>${usage.coins_used} Coin</td>
                                <td>${usage.description}</td>
                            </tr>`;
                    });
                } else {
                    usageTableBody.innerHTML = '<tr><td colspan="3" class="text-center">Không có lịch sử sử dụng</td></tr>';
                }
            } else {
                console.error('Error:', data.message);
                alert('Không thể tải lịch sử giao dịch.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Có lỗi xảy ra khi tải lịch sử giao dịch.');
        });
    });
</script>
