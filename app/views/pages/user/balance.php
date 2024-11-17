<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h3 class="card-title text-center mb-4 text-primary">Nạp Số Dư</h3>

            <!-- Hiển thị số dư hiện tại -->
            <div class="form-group mb-4 text-center">
                <label class="form-label fw-bold">Số Dư Hiện Tại:</label>
                <div class="d-flex justify-content-center align-items-center">
                    <span id="balance" class="fw-bold text-success me-2 fs-4">1000</span>
                    <img src="public/img/coin.png" alt="Coin Icon" style="width: 32px; height: 32px;">
                </div>
            </div>

            <!-- Form Nạp Số Dư -->
            <form id="rechargeForm">
                <!-- Chọn phương thức nạp -->
                <div class="form-group mb-4">
                    <label class="form-label fw-bold">Chọn Phương Thức Nạp:</label>
                    <div class="d-flex justify-content-around mt-3">
                        <button type="button" class="btn btn-outline-primary recharge-option" data-method="code">Nhập Mã Code</button>
                        <button type="button" class="btn btn-outline-success recharge-option" data-method="momo">
                            <img src="public/img/download/momo.png" alt="MoMo" style="width: 50px; height: auto;">
                        </button>
                        <button type="button" class="btn btn-outline-info recharge-option" data-method="zalopay">
                            <img src="public/img/download/zalopay.png" alt="ZaloPay" style="width: 50px; height: auto;">
                        </button>
                    </div>
                </div>

                <!-- Chọn gói nạp -->
                <div id="priceOptions" class="form-group mb-4" style="display: none;">
                    <label class="form-label fw-bold">Chọn Gói Nạp:</label>
                    <table class="table table-bordered mt-3">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Giá</th>
                                <th scope="col">Thêm điểm</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="radio" name="priceOption" value="10000" data-coins="10"> 10,000 đ</td>
                                <td>10 Coin</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="priceOption" value="20000" data-coins="20"> 20,000 đ</td>
                                <td>20 Coin</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="priceOption" value="50000" data-coins="50"> 50,000 đ</td>
                                <td>50 Coin</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="priceOption" value="100000" data-coins="100"> 100,000 đ</td>
                                <td>100 Coin</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Nhập mã code -->
                <div id="codeInputSection" class="form-group mb-4" style="display: none;">
                    <label for="codeInput" class="form-label fw-bold">Nhập Mã Code</label>
                    <input type="text" id="codeInput" name="codeInput" class="form-control" placeholder="Nhập mã code của bạn">
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary mt-3" id="confirmCodeBtn">Xác Nhận</button>
                    </div>
                </div>

                <!-- Hiển thị chi tiết giao dịch -->
                <div id="transactionDetails" class="form-group mb-4" style="display: none;">
                    <h5 class="fw-bold">Chi Tiết Giao Dịch</h5>
                    <p><strong>Sản phẩm được chọn:</strong> <span id="selectedCoins">0 Coin</span></p>
                    <p><strong>Phương thức thanh toán:</strong> <span id="paymentMethod"></span></p>
                    <p><strong>Giá:</strong> <span id="paymentPrice"></span> VNĐ</p>
                    <p><strong>Username:</strong> dragneel_user</p>
                    <div class="text-center">
                        <button type="button" class="btn btn-success" id="confirmTransactionBtn">Xác Nhận Thanh Toán</button>
                    </div>
                    <div id="qrCode" class="text-center mt-4" style="display: none;">
                        <img src="public/img/qr.png" alt="QR Code" style="width: 200px; height: auto;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rechargeOptions = document.querySelectorAll('.recharge-option');
        const priceOptions = document.getElementById('priceOptions');
        const codeInputSection = document.getElementById('codeInputSection');
        const transactionDetails = document.getElementById('transactionDetails');
        const paymentMethod = document.getElementById('paymentMethod');
        const paymentPrice = document.getElementById('paymentPrice');
        const selectedCoins = document.getElementById('selectedCoins');
        const qrCode = document.getElementById('qrCode');
        let selectedMethod = '';

        rechargeOptions.forEach(option => {
            option.addEventListener('click', function() {
                selectedMethod = this.dataset.method;
                codeInputSection.style.display = selectedMethod === 'code' ? 'block' : 'none';
                priceOptions.style.display = selectedMethod !== 'code' ? 'block' : 'none';
                transactionDetails.style.display = 'none'; // Ẩn chi tiết giao dịch khi thay đổi phương thức
                qrCode.style.display = 'none'; // Ẩn mã QR khi thay đổi phương thức

                if (selectedMethod === 'momo') {
                    paymentMethod.textContent = 'MoMo';
                } else if (selectedMethod === 'zalopay') {
                    paymentMethod.textContent = 'ZaloPay';
                }
            });
        });

        document.querySelectorAll('input[name="priceOption"]').forEach(option => {
            option.addEventListener('change', function() {
                const price = this.value;
                const coins = this.dataset.coins;
                paymentPrice.textContent = price + ' VNĐ';
                selectedCoins.textContent = coins + ' Coin';
                transactionDetails.style.display = 'block';
            });
        });

        document.getElementById('confirmCodeBtn').addEventListener('click', function() {
            alert('Mã code đã được xác nhận. Xử lý nạp số dư.');
        });

        document.getElementById('confirmTransactionBtn').addEventListener('click', function() {
            qrCode.style.display = 'block';
            alert('Quét QR để thanh toán ' + paymentMethod.textContent + '.');
        });
    });
</script>

