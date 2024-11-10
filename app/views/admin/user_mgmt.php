<?php include(__DIR__ . '/../layouts/header.php'); ?>
<?php include(__DIR__ . '/../layouts/navbar.php'); ?>

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
                    <th>Loại tài khoản</th>
                    <th>Ngày đăng ký</th>
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
                        <td><?php echo date("Y-m-d"); ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary mx-1">Xem</button>
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
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
                // Thực hiện xóa (chỉ ví dụ)
                this.closest('tr').remove();
            }
        });
    });
</script>

<?php include(__DIR__ . '/../layouts/footer.php'); ?>
