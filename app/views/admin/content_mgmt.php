<?php include(__DIR__ . '/../layouts/header.php'); ?>
<?php include(__DIR__ . '/../layouts/navbar.php'); ?>

<div class="container mt-5">
    <h3 class="text-center text-primary mb-4">Quản Lý Nội Dung</h3>

    <!-- Quản lý sự kiện -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white" style="background-color: #6a0dad;">
            <h5 class="text-center bg-dark fw-bold mb-0 text-white">Sự Kiện</h5>
        </div>
        <div class="card-body">
            <!-- Thanh tìm kiếm sự kiện -->
            <div class="mb-3">
                <input type="text" class="form-control" id="eventSearch" placeholder="Tìm kiếm sự kiện...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="eventTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên Sự Kiện</th>
                            <th>Ngày Bắt Đầu</th>
                            <th>Ngày Kết Thúc</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>Sự Kiện <?php echo $i; ?></td>
                                <td><?php echo date("Y-m-d"); ?></td>
                                <td><?php echo date("Y-m-d", strtotime("+7 days")); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">Xem</button>
                                    <button class="btn btn-sm btn-warning">Sửa</button>
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <button class="btn btn-primary">Thêm Sự Kiện Mới</button>
            </div>
        </div>
    </div>

    <!-- Quản lý Heroes -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white" style="background-color: #6a0dad;">
            <h5 class="text-center bg-dark fw-bold mb-0 text-white">Heroes</h5>
        </div>
        <div class="card-body">
            <!-- Thanh tìm kiếm Heroes -->
            <div class="mb-3">
                <input type="text" class="form-control" id="heroSearch" placeholder="Tìm kiếm Hero...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="heroTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên Hero</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>Hero <?php echo $i; ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">Xem</button>
                                    <button class="btn btn-sm btn-warning">Sửa</button>
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <button class="btn btn-primary">Thêm Hero Mới</button>
            </div>
        </div>
    </div>

    <!-- Quản lý Maps -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white" style="background-color: #6a0dad;">
            <h5 class="text-center bg-dark fw-bold mb-0 text-white">Maps</h5>
        </div>
        <div class="card-body">
            <!-- Thanh tìm kiếm Maps -->
            <div class="mb-3">
                <input type="text" class="form-control" id="mapSearch" placeholder="Tìm kiếm Map...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="mapTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên Map</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>Map <?php echo $i; ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">Xem</button>
                                    <button class="btn btn-sm btn-warning">Sửa</button>
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <button class="btn btn-primary">Thêm Map Mới</button>
            </div>
        </div>
    </div>
</div>


<script>
    // Hàm lọc tìm kiếm
    function filterTable(inputId, tableId) {
        const input = document.getElementById(inputId);
        const filter = input.value.toLowerCase();
        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName('tr');
        
        for (let i = 1; i < rows.length; i++) { // Bắt đầu từ 1 để bỏ qua tiêu đề bảng
            const cells = rows[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    const text = cells[j].textContent || cells[j].innerText;
                    if (text.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }
            }
            rows[i].style.display = match ? '' : 'none';
        }
    }

    // Gắn sự kiện tìm kiếm cho từng phần
    document.getElementById('eventSearch').addEventListener('input', function () {
        filterTable('eventSearch', 'eventTable');
    });
    document.getElementById('heroSearch').addEventListener('input', function () {
        filterTable('heroSearch', 'heroTable');
    });
    document.getElementById('mapSearch').addEventListener('input', function () {
        filterTable('mapSearch', 'mapTable');
    });
</script>

<?php include(__DIR__ . '/../layouts/footer.php'); ?>
