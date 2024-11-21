<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h3 class="card-title text-center mb-4 text-primary">Thông Tin Tài Khoản</h3>

            <!-- Form cập nhật thông tin -->
            <form method="post" enctype="multipart/form-data" id="updateInfoForm">
                <!-- Ảnh đại diện -->
                <div class="form-group text-center mb-4">
                    <?php
                    // If profile picture exists, display it, otherwise show a default image
                    $profilePicPath = 'public/img/avatar/' . $_SESSION['user']['profile_pic'];
                    $profilePicPath = file_exists($profilePicPath)  ? $profilePicPath : 'public/img/account-black.png';
                    ?>
                    <img src="<?= $profilePicPath ?>" alt="User Avatar" id="userAvatar" class="rounded-circle border img-thumbnail shadow-lg mb-3" style="width: 150px; height: 150px;">
                    <div class="mt-2">
                        <input type="file" name="profile_pic" accept="image/*" class="form-control form-control-sm border-primary rounded-pill shadow-sm">
                        <small class="form-text text-muted">Chọn ảnh để thay đổi ảnh đại diện.</small>
                    </div>
                </div>

                <!-- Loại tài khoản -->
                <div class="form-group mb-4 text-center">
                    <span class="badge bg-gradient bg-success text-light fs-5 shadow">
                        Tài Khoản: <?= ucfirst($_SESSION['user']['subscription_type']); ?>
                    </span>
                </div>

                <!-- Hiển thị tên người dùng -->
                <div class="form-group mb-4">
                    <label for="username" class="form-label fw-bold text-secondary">Tên Người Dùng</label>
                    <input type="text" name="username" id="username" value="<?= $_SESSION['user']['username']; ?>" class="form-control border-primary shadow-sm rounded-pill" placeholder="Nhập tên người dùng" readonly>
                </div>

                <!-- Địa chỉ email -->
                <div class="form-group mb-4">
                    <label for="email" class="form-label fw-bold text-secondary">Địa Chỉ Email</label>
                    <input type="email" name="email" id="email" value="<?= $_SESSION['user']['email']; ?>" class="form-control border-primary shadow-sm rounded-pill" placeholder="Nhập địa chỉ email">
                </div>

                <!-- Đổi mật khẩu -->
                <div class="form-group mb-4">
                    <label for="newPassword" class="form-label fw-bold text-secondary">Mật Khẩu Mới</label>
                    <div class="input-group">
                        <input type="password" name="newPassword" id="newPassword" class="form-control border-primary shadow-sm rounded-pill" placeholder="Nhập mật khẩu mới">
                        <button type="button" id="toggleNewPassword" class="btn btn-outline-secondary rounded-pill shadow-sm" style="margin-left: -45px; z-index: 1;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Xác nhận mật khẩu mới -->
                <div class="form-group mb-4">
                    <label for="confirmPassword" class="form-label fw-bold text-secondary">Xác Nhận Mật Khẩu Mới</label>
                    <div class="input-group">
                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control border-primary shadow-sm rounded-pill" placeholder="Nhập lại mật khẩu mới">
                        <button type="button" id="toggleConfirmPassword" class="btn btn-outline-secondary rounded-pill shadow-sm" style="margin-left: -45px; z-index: 1;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Xác thực hai yếu tố -->
                <div class="form-group mb-4">
                    <label class="form-label fw-bold text-secondary">Bảo Mật Xác Thực Hai Yếu Tố (2FA)</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="2faToggle" name="2fa" <?= $_SESSION['user']['two_fa_enabled'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="2faToggle">Kích Hoạt 2FA</label>
                    </div>
                    <small class="form-text text-muted">Kích hoạt xác thực hai yếu tố để bảo vệ tài khoản tốt hơn.</small>
                </div>

                <!-- Nút cập nhật thông tin -->
                <div class="form-group text-center">
                    <button type="button" id="updateInfoBtn" class="btn btn-primary btn-lg shadow-lg rounded-pill">Cập Nhật Thông Tin</button>
                </div>

                <div id="errorMessages" class="mt-3"></div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Current Password Verification -->
<div class="modal fade" id="currentPasswordModal" tabindex="-1" aria-labelledby="currentPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="currentPasswordModalLabel">Xác Nhận Mật Khẩu Hiện Tại</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="currentPasswordInput">Mật Khẩu Hiện Tại</label>
                    <input type="password" id="currentPasswordInput" class="form-control" placeholder="Nhập mật khẩu hiện tại">
                </div>
                <div id="modalErrorMessages" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" id="verifyPasswordBtn" class="btn btn-primary">Xác Nhận</button>
            </div>
        </div>
    </div>
</div>

<script>
let modal;
document.addEventListener('DOMContentLoaded', function () {
    modal = new bootstrap.Modal(document.getElementById('currentPasswordModal'));
});
document.getElementById('updateInfoBtn').addEventListener('click', function () {
    const emailField = document.getElementById('email');
    const newPasswordField = document.getElementById('newPassword');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const errorMessageContainer = document.getElementById('errorMessages');

    // Clear previous error messages
    errorMessageContainer.innerHTML = '';

    let hasError = false;

    // Validate email format
    const email = emailField.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        const error = document.createElement('p');
        error.classList.add('text-danger');
        error.textContent = 'Email không đúng định dạng.';
        errorMessageContainer.appendChild(error);
        hasError = true;
    }

    // Validate new password and confirmation
    const newPassword = newPasswordField.value.trim();
    const confirmPassword = confirmPasswordField.value.trim();
    if (newPassword || confirmPassword) {
        if (newPassword.length < 4 || newPassword.length > 20) {
            const error = document.createElement('p');
            error.classList.add('text-danger');
            error.textContent = 'Mật khẩu mới phải từ 4-20 ký tự.';
            errorMessageContainer.appendChild(error);
            hasError = true;
        }
        if (newPassword !== confirmPassword) {
            const error = document.createElement('p');
            error.classList.add('text-danger');
            error.textContent = 'Mật khẩu mới và xác nhận không khớp.';
            errorMessageContainer.appendChild(error);
            hasError = true;
        }
    }

    // If no errors, show the modal
    if (!hasError) {
        modal.show();
    }
});

document.getElementById('verifyPasswordBtn').addEventListener('click', function () {
    const currentPasswordInput = document.getElementById('currentPasswordInput');
    const currentPassword = currentPasswordInput.value.trim();
    const errorMessageContainer = document.getElementById('modalErrorMessages');

    // Clear previous error messages
    errorMessageContainer.innerHTML = '';

    if (!currentPassword) {
        const error = document.createElement('p');
        error.classList.add('text-danger');
        error.textContent = 'Vui lòng nhập mật khẩu hiện tại.';
        errorMessageContainer.appendChild(error);
        return;
    }
    
    // Verify password via AJAX
    fetch('index.php?ajax=verifyCurrentPassword', {
        method: 'POST',
        body: JSON.stringify({ password: currentPassword }),
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to verify password.');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                submitForm();
                modal.hide();
            } else {
                const error = document.createElement('p');
                error.classList.add('text-danger');
                error.textContent = 'Mật khẩu hiện tại không đúng.';
                errorMessageContainer.appendChild(error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorMessage = document.createElement('p');
            errorMessage.classList.add('text-danger');
            errorMessage.textContent = 'Đã xảy ra lỗi khi xác minh mật khẩu. Vui lòng thử lại sau.';
            errorMessageContainer.appendChild(errorMessage);
        });
});

function submitForm() {
    const form = document.getElementById("updateInfoForm");
    const formData = new FormData(form);

    fetch("index.php?ajax=updateUserInfo", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            const errorMessagesDiv = document.getElementById("errorMessages");
            errorMessagesDiv.innerHTML = ""; // Clear previous messages

            if (data.success) {
                errorMessagesDiv.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        ${data.message}
                    </div>
                `;
                const reloadMessage = document.createElement('div');
                reloadMessage.classList.add('alert', 'alert-info');
                reloadMessage.textContent = 'Trang sẽ tự động tải lại trong 3 giây...';
                errorMessagesDiv.appendChild(reloadMessage);
                setTimeout(function() {
                    location.reload();
                }, 3000);
            } else {
                errorMessagesDiv.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        ${data.message}
                    </div>
                `;
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            const errorMessagesDiv = document.getElementById("errorMessages");
            errorMessagesDiv.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    Có lỗi xảy ra. Vui lòng thử lại sau.
                </div>
            `;
        });
}
</script>



<script>
    function setupPasswordToggle(buttonId, fieldId) {
    document.getElementById(buttonId).addEventListener('click', function () {
        const passwordField = document.getElementById(fieldId);
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
}

setupPasswordToggle('toggleNewPassword', 'newPassword');
setupPasswordToggle('toggleConfirmPassword', 'confirmPassword');

</script>
