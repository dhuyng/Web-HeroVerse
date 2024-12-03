<div class="container mt-5">
    <h3 class="text-center mb-4 text-primary ">Quản Lý Người Dùng</h3>

    <!-- Thanh tìm kiếm và bộ lọc -->
    <div class="d-flex justify-content-between mb-3">
        <input type="text" class="form-control me-2 w-25" placeholder="Tìm kiếm người dùng..." id="searchInput">
        <select class="form-select w-25" id="accountTypeFilter">
            <option value="">Tất cả loại tài khoản</option>
            <option value="Free">Free</option>
            <option value="Pro">Pro</option>
            <option value="Premium">Premium</option>
        </select>
        <button class="btn btn-primary" id="filterBtn">Lọc</button>
    </div>

    <!-- Bảng người dùng -->
    <div class="table-responsive shadow-sm">
        <table class="table table-hover rounded">
            <thead class="table-dark text-light">
                <tr>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Loại tài khoản</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <tr class="user-row">
                        <td><?php echo $i; ?></td>
                        <td>user<?php echo $i; ?></td>
                        <td>user<?php echo $i; ?>@example.com</td>
                        <td>
                            <?php
                                // Phân loại tài khoản ngẫu nhiên
                                echo $i % 3 === 0 ? 'Free' : ($i % 3 === 1 ? 'Pro' : 'Premium');
                            ?>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning mx-1">Sửa</button>
                            <button class="btn btn-sm btn-danger mx-1 delete-btn">Xóa</button>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <!-- Nút thêm người dùng mới -->
    <div class="text-center mt-4">
        <button class="btn btn-primary btn-lg shadow">Thêm Người Dùng Mới</button>
    </div>

<!-- Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Chỉnh Sửa Người Dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên Người Dùng</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subscription" class="form-label">Loại Tài Khoản</label>
                        <select class="form-select" id="subscription" name="subscription" required>
                            <option value="basic">Basic</option>
                            <option value="pro">Pro</option>
                            <option value="premium">Premium</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary" id="saveUserBtn">Lưu Thay Đổi</button>
            </div>
        </div>
    </div>
</div>

</div>

<script>
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('btn-warning')) {
        const row = event.target.closest('tr'); // Find the row
        const userId = row.querySelector('td:first-child').textContent.trim();
        const username = row.cells[1].textContent.trim();
        const email = row.cells[2].textContent.trim();
        const role = row.cells[3].textContent.trim();
        const subscription = row.cells[4].textContent.trim();



        // Populate the modal inputs
        document.getElementById('editUserId').value = userId;
        document.getElementById('username').value = username;
        document.getElementById('email').value = email;
        document.getElementById('role').value = role;
        document.getElementById('subscription').value = subscription;

        // Show the modal
        const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        editUserModal.show();
    }
});

document.getElementById('saveUserBtn').addEventListener('click', function () {
    const form = document.getElementById('editUserForm');
    const formData = new FormData(form);


    fetch('index.php?ajax=updateUser', {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(formData)),
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok.');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update the row in the table
                const userId = formData.get('id');

                const rows = document.querySelectorAll('.user-row');
                rows.forEach(row => {
                    if (row.cells[0].textContent === userId) {
                        row.cells[1].textContent = formData.get('username');
                        row.cells[2].textContent = formData.get('email');
                        row.cells[3].textContent = formData.get('role');
                        row.cells[4].textContent = formData.get('subscription');
                    }
                });

                alert('Thông tin người dùng đã được cập nhật.');
                bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
            } else {
                alert(data.message || 'Cập nhật thất bại.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật người dùng.');
        });
});


</script>



<script>
    // Thêm tính năng tìm kiếm
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');
        rows.forEach(row => {
            const username = row.cells[1].textContent.toLowerCase();
            row.style.display = username.includes(searchValue) ? '' : 'none';
        });
    });

    // Thêm tính năng lọc loại tài khoản
    document.getElementById('filterBtn').addEventListener('click', function () {
        const accountTypeFilter = document.getElementById('accountTypeFilter').value;
        const rows = document.querySelectorAll('.user-row');
        rows.forEach(row => {
            const accountType = row.cells[3].textContent;
            row.style.display = accountTypeFilter === '' || accountType === accountTypeFilter ? '' : 'none';
        });
    });

    // Thêm xác nhận khi xóa
    // document.querySelectorAll('.delete-btn').forEach(button => {
    //     button.addEventListener('click', function () {
    //         if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
    //             // Thực hiện xóa (chỉ ví dụ)
    //             this.closest('tr').remove();
    //         }
    //     });
    // });
</script>


<script>

document.addEventListener('DOMContentLoaded', function () {
        fetch('index.php?ajax=getAllUsers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.data);
            if (data.success) {
                const userTable = document.getElementById('userTable');
                userTable.innerHTML = '';

                if (data.data.length > 0) {

                data.data.forEach(user => {
                    const row = document.createElement('tr');
                    row.classList.add('user-row');
                    row.innerHTML = `
                        <td class="user-id">${user.id}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>${user.subscription_type ?? "_________"}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning mx-1">Sửa</button>
                            <button class="btn btn-sm btn-danger mx-1 delete-btn">Xóa</button>
                        </td>
                    `;
                    userTable.appendChild(row);
                });
            }
            else{
                userTable.innerHTML = '<tr><td colspan="5" class="text-center">Không có người dùng nào</td></tr>';
            }
            }
        else{
            console.error('Error:', data.message);
            alert('Không thể tải danh sách người dùng.');
        }

        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Có lỗi xảy ra khi tải danh sách người dùng.');
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Add event listener for delete buttons
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-btn')) {
            const row = event.target.closest('tr'); // Get the closest table row
            if (!row) {
                alert('Error: Unable to locate the row.');
                return;
            }

            const userIdElement = row.querySelector('.user-id'); // Find the element with the User ID
            if (!userIdElement) {
                alert('Error: User ID not found.');
                return;
            }

            const userId = userIdElement.textContent.trim(); // Fetch and trim the User ID
            if (!userId) {
                alert('Error: Invalid User ID.');
                return;
            }

            // Confirm before deleting
            if (confirm(`Bạn có chắc chắn muốn xóa người dùng với ID: ${userId}?`)) {
                deleteUser(userId, row);
            }
        }
    });
});

// Function to delete the user via AJAX
function deleteUser(userId, row) {
    const errorContainer = document.getElementById('errorMessages') || createErrorContainer();
    fetch('index.php?ajax=deleteUser', {
        method: 'POST',
        body: JSON.stringify({ id: userId }),
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
        .then((response) => {
            if (!response.ok) throw new Error('Network response was not ok.');
            return response.json();
        })
        .then((data) => {
            errorContainer.innerHTML = ''; // Clear previous messages

            if (data.success) {
                row.remove(); // Remove the table row on success
                errorContainer.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        Người dùng đã được xóa thành công.
                    </div>
                `;
            } else {
                errorContainer.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        ${data.message || 'Không thể xóa người dùng.'}
                    </div>
                `;
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            errorContainer.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    Có lỗi xảy ra khi xóa người dùng. Vui lòng thử lại sau.
                </div>
            `;
        });
}

// Helper to create a message container if not present
function createErrorContainer() {
    const container = document.createElement('div');
    container.id = 'errorMessages';
    document.body.prepend(container); // Add it to the top of the body
    return container;
}

</script>
