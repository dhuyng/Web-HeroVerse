<?php
// Kiểm tra xem người dùng đã đăng nhập chưa
$is_logged_in = isset($_SESSION['user']['id']); // Giả sử bạn lưu ID người dùng vào session khi đăng nhập thành công
?>

<!-- Pricing Section -->
<div class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="text-center">
            <h1 class="display-5 mb-5">PRICING</h1>
        </div>
        <div class="row g-4">
            <!-- Free Plan -->
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="pricing-plan bg-white text-center" style="min-height: 400px;">
                    <h4 class="bg-dark text-white">Free</h4>
                    <p class="mb-4"><h1>$0</h1>/ month</p>
                    <ul class="list-unstyled">
                        <li>Truy cập các tính năng cơ bản</li>
                        <li>Mở khóa một số màn chơi giới hạn</li>
                        <li>Hỗ trợ tiêu chuẩn</li>
                    </ul>
                    <?php if (!$is_logged_in): ?>
                            <a href="login" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideỈnight fw-bold">Sign up for free</a> 
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pro Plan -->
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="pricing-plan bg-white text-center" style="min-height: 400px;">
                    <h4 class="bg-dark text-white">Pro</h4>
                    <p class="mb-4"><h1>$10</h1>/ month</p>
                    <ul class="list-unstyled">
                        <li>Truy cập các tính năng cao cấp</li>
                        <li>Mở khóa tất cả các màn chơi</li>
                        <li>Cơ hội nhận vật phẩm đặc biệt</li>
                        <li>Hỗ trợ ưu tiên</li>
                    </ul>
                    <button class="btn btn-primary py-sm-3 px-sm-5 me-3 fw-bold unlock-plan" data-plan="Pro" data-price="10">Unlock Now</button>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="pricing-plan bg-white text-center" style="min-height: 400px;">
                    <h4 class="bg-dark text-white">Premium</h4>
                    <p class="mb-4"><h1>$20</h1>/ month</p>
                    <ul class="list-unstyled">
                        <li>Tất cả tính năng của gói Pro</li>
                        <li>Cơ hội trải nghiệm các bản beta độc quyền</li>
                        <li>Hỗ trợ VIP với phản hồi nhanh chóng</li>
                        <li>Giảm giá khi các vật phẩm</li>
                        <li>Coupon quà tặng nhân dịp sinh nhật</li>
                    </ul>
                    <button class="btn btn-primary py-sm-3 px-sm-5 me-3 fw-bold unlock-plan" data-plan="Premium" data-price="20">Unlock Now</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Confirm Your Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Plan:</strong> <span id="planName"></span></p>
                <p><strong>Price:</strong> $<span id="planPrice"></span></p>
                <p><strong>Buying User:</strong> <?= $_SESSION['user']['username'] ?? 'Guest'; ?></p>
                <p>Choose your payment method:</p>
                <div class="d-flex justify-content-around">
                    <button class="btn btn-outline-primary">MoMo</button>
                    <button class="btn btn-outline-info">ZaloPay</button>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button id="proceedToPaymentBtn" class="btn btn-primary">Proceed to Payment</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.unlock-plan').forEach(button => {
        button.addEventListener('click', function () {
            const plan = this.dataset.plan;
            const price = this.dataset.price;
            const isLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false'; ?>;

            if (!isLoggedIn) {
                window.location.href = "login";
            } else {
                // Populate modal details
                document.getElementById('planName').textContent = plan;
                document.getElementById('planPrice').textContent = price;
                new bootstrap.Modal(document.getElementById('paymentModal')).show();
            }
        });
    });

    document.querySelectorAll('.modal-body .btn-outline-primary, .modal-body .btn-outline-info').forEach(button => {
        button.addEventListener('click', function () {
            // Remove active class from all buttons
            document.querySelectorAll('.modal-body .btn-outline-primary, .modal-body .btn-outline-info').forEach(btn => {
                btn.classList.remove('active');
            });
            // Add active class to the clicked button
            this.classList.add('active');
        });
    });

    document.getElementById('proceedToPaymentBtn').addEventListener('click', function () {
        const plan = document.getElementById('planName').textContent;
        const priceUSD = document.getElementById('planPrice').textContent;
        const conversionRate = 25414; // USD to VND conversion
        const priceVND = priceUSD * conversionRate;

        // Select payment method
        const paymentMethod = document.querySelector('.modal-body .btn-outline-primary.active, .modal-body .btn-outline-info.active')?.textContent;
        if (!paymentMethod) {
            alert('Please select a payment method.');
            return;
        }

        const transactionData = {
            extraData : {
                userId : "<?=$_SESSION['user']['id']?>",
                subscription : true,
                plan : plan.toLowerCase()
            },
            orderId : "<?=$_SESSION['user']['username'] . '_'. time()?>" ,
            amount: priceVND,
            orderInfo: `Subscription Plan: ${plan}`,
            paymentMethod: paymentMethod.toLowerCase(), // e.g., 'momo' or 'zalopay'
        };

        fetch('index.php?ajax=confirmTransaction', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(transactionData),
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Error:' + data.message);
                }
                if (data.payUrl) window.location.href = data.payUrl;
                else alert('Error initiating payment: ' + data.payUrl) ;
            })
            .catch(err => {
                console.error('Error:', err);
                alert('An unexpected error occured. Please try again.');
            });
    });


</script>

