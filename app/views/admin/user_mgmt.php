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
</div>


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
