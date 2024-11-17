<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4 ">
        <div class="card-body p-4">
            <h3 class="card-title text-center mb-4 text-primary">Thông Tin Tài Khoản</h3>

            <!-- Form cập nhật thông tin -->
            <form method="post" enctype="multipart/form-data">
                <!-- Ảnh đại diện -->
                <div class="form-group text-center mb-4">
                    <img src="public/img/account-black.png" alt="User Avatar" id="userAvatar" class="rounded-circle border img-thumbnail shadow-lg mb-3" style="width: 150px; height: 150px;">
                    <div class="mt-2">
                        <input type="file" name="profile_pic" accept="image/*" class="form-control form-control-sm border-primary rounded-pill shadow-sm">
                        <small class="form-text text-muted">Chọn ảnh để thay đổi ảnh đại diện.</small>
                    </div>
                </div>

                <!-- Loại tài khoản -->
                <div class="form-group mb-4 text-center">
                    <span class="badge bg-gradient bg-success text-light fs-5 shadow">Tài Khoản: Pro</span>
                </div>

                <!-- Hiển thị tên người dùng -->
                <div class="form-group mb-4">
                    <label for="username" class="form-label fw-bold text-secondary">Tên Người Dùng</label>
                    <input type="text" name="username" id="username" value="dragneel_user" class="form-control border-primary shadow-sm rounded-pill" placeholder="Nhập tên người dùng">
                </div>

                <!-- Đổi địa chỉ email -->
                <div class="form-group mb-4">
                    <label for="email" class="form-label fw-bold text-secondary">Địa Chỉ Email</label>
                    <input type="email" name="email" id="email" value="user@example.com" class="form-control border-primary shadow-sm rounded-pill" placeholder="Nhập địa chỉ email">
                </div>

                <!-- Hiển thị mật khẩu hiện tại -->
                <div class="form-group mb-4">
                    <label for="currentPassword" class="form-label fw-bold text-secondary">Mật Khẩu Hiện Tại</label>
                    <div class="input-group">
                        <input type="password" id="currentPassword" value="123456" class="form-control border-primary shadow-sm rounded-pill" readonly>
                        <button type="button" id="toggleCurrentPassword" class="btn btn-outline-secondary rounded-pill shadow-sm" style="margin-left: -45px; z-index: 1;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Đổi mật khẩu -->
                <div class="form-group mb-4">
                    <label for="password" class="form-label fw-bold text-secondary">Mật Khẩu Mới</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control border-primary shadow-sm rounded-pill" placeholder="Nhập mật khẩu mới">
                        <button type="button" id="togglePassword" class="btn btn-outline-secondary rounded-pill shadow-sm" style="margin-left: -45px; z-index: 1;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Hiển thị số dư -->
                <div class="form-group mb-4">
                    <label class="form-label fw-bold text-secondary">Số Dư Hiện Tại:</label>
                    <div class="d-flex align-items-center mt-2">
                        <span id="balance" class="fw-bold text-success me-2 fs-4">1000</span>
                        <img src="public/img/coin.png" alt="Coin Icon" style="width: 32px; height: 32px;">
                    </div>
                </div>

                <!-- Xác thực hai yếu tố -->
                <div class="form-group mb-4">
                    <label class="form-label fw-bold text-secondary">Bảo Mật Xác Thực Hai Yếu Tố (2FA)</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="2faToggle" name="2fa" checked>
                        <label class="form-check-label" for="2faToggle">Kích Hoạt 2FA</label>
                    </div>
                    <small class="form-text text-muted">Kích hoạt xác thực hai yếu tố để bảo vệ tài khoản tốt hơn.</small>
                </div>

                <!-- Đăng xuất khỏi thiết bị khác -->
                <div class="form-group mb-4 text-center">
                    <button type="button" class="btn btn-warning btn-sm shadow rounded-pill">Đăng Xuất Khỏi Tất Cả Thiết Bị</button>
                </div>

                <!-- Nút cập nhật thông tin -->
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg shadow-lg rounded-pill">Cập Nhật Thông Tin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const passwordFieldType = passwordField.getAttribute('type');
        const icon = this.querySelector('i');

        if (passwordFieldType === 'password') {
            passwordField.setAttribute('type', 'text');
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordField.setAttribute('type', 'password');
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    document.getElementById('toggleCurrentPassword').addEventListener('click', function () {
        const currentPasswordField = document.getElementById('currentPassword');
        const currentPasswordFieldType = currentPasswordField.getAttribute('type');
        const icon = this.querySelector('i');

        if (currentPasswordFieldType === 'password') {
            currentPasswordField.setAttribute('type', 'text');
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            currentPasswordField.setAttribute('type', 'password');
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>
