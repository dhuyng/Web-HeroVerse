<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h3 class="card-title text-center mb-4 text-primary">Thông Tin Tài Khoản</h3>
        
            <!-- Form cập nhật thông tin -->
            <form method="post" enctype="multipart/form-data">
                <!-- Ảnh đại diện -->
                <div class="form-group text-center mb-4">
                    <img src="public/img/account-black.png" alt="User Avatar" id="userAvatar" class="rounded-circle border img-thumbnail shadow wow fadeIn" style="width: 150px; height: 150px;">
                    <div class="mt-3">
                        <input type="file" name="profile_pic" accept="image/*" class="form-control form-control-sm">
                        <small class="form-text text-muted">Chọn ảnh để thay đổi ảnh đại diện.</small>
                    </div>
                </div>

                <!-- Loại tài khoản -->
                <div class="form-group mb-4 text-center">
                    <span class="badge bg-success text-light fs-5 shadow wow bounceIn" data-wow-delay="0.2s">Tài Khoản: ADMIN</span>
                </div>

                <!-- Hiển thị tên người dùng -->
                <div class="form-group mb-4">
                    <label for="username" class="form-label fw-bold">Tên Người Dùng</label>
                    <input type="text" name="username" id="username" value="dragneel_user" class="form-control border-primary shadow-sm wow fadeIn" placeholder="Nhập tên người dùng">
                </div>

                <!-- Đổi mật khẩu -->
                <div class="form-group mb-4">
                    <label for="password" class="form-label fw-bold">Mật Khẩu Mới</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control border-primary shadow-sm wow fadeIn" placeholder="Nhập mật khẩu mới">
                        <button type="button" id="togglePassword" class="btn btn-outline-secondary rounded-pill shadow-sm" style="margin-left: -45px; z-index: 1;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Nhập lại mật khẩu -->
                <div class="form-group mb-4">
                    <label for="confirm_password" class="form-label fw-bold">Nhập Lại Mật Khẩu</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control border-primary shadow-sm wow fadeIn" placeholder="Nhập lại mật khẩu mới">
                        <button type="button" id="toggleConfirmPassword" class="btn btn-outline-secondary rounded-pill shadow-sm" style="margin-left: -45px; z-index: 1;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Nút cập nhật thông tin -->
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg shadow wow pulse" data-wow-iteration="infinite">Cập Nhật Thông Tin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Chức năng hiển thị ẩn mật khẩu
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

    // Chức năng hiển thị ẩn mật khẩu nhập lại
    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const confirmPasswordField = document.getElementById('confirm_password');
        const confirmPasswordFieldType = confirmPasswordField.getAttribute('type');
        const icon = this.querySelector('i');

        if (confirmPasswordFieldType === 'password') {
            confirmPasswordField.setAttribute('type', 'text');
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            confirmPasswordField.setAttribute('type', 'password');
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>
