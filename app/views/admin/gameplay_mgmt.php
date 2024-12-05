<?php
// /view/admin/content_mgmt.php
require_once(__DIR__ . "/../../controllers/MapController.php");

$mapController = new MapController();
$response = null;

// Xử lý các action POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'addMap':
            ob_start();
            $mapController->addMap();
            $response = ob_get_clean();
            break;
        case 'deleteMap':
            ob_start();
            $mapController->deleteMap();
            $response = ob_get_clean();
            break;
        case 'editMap':
            ob_start();
            $mapController->updateMap();
            $response = ob_get_clean();
            break;
    }

    $response = json_decode($response, true);
}

// Lấy danh sách bản đồ
$maps = $mapController->getAllMaps();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Maps</title>
    <link rel="stylesheet" href="/path/to/your/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center text-primary mb-4">Quản Lý Nội Dung</h3>

    <!-- Hiển thị thông báo -->
    <?php if ($response): ?>
        <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($response['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Quản lý bản đồ -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="text-center fw-bold mb-0">Quản Lý Bản Đồ</h5>
        </div>
        <div class="card-body">
            <!-- Thanh tìm kiếm bản đồ -->
            <div class="mb-3">
                <input type="text" class="form-control" id="mapSearch" placeholder="Tìm kiếm bản đồ...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="mapTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên Bản Đồ</th>
                            <th>Ảnh Bản Đồ</th>
                            <th>Ngày Tạo</th>
                            <th>Ngày Cập Nhật</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($maps) > 0): ?>
                            <?php foreach ($maps as $map): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($map['id']); ?></td>
                                    <td><?php echo htmlspecialchars($map['name']); ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($map['image']); ?>" 
                                             alt="Map Image" style="width: 100px;">
                                    </td>
                                    <td><?php echo htmlspecialchars($map['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($map['updated_at']); ?></td>
                                    <td>
                                        <!-- Sửa bản đồ -->
                                        <button class="btn btn-warning btn-sm edit-map-btn" 
                                                data-id="<?php echo $map['id']; ?>" 
                                                data-name="<?php echo htmlspecialchars($map['name']); ?>" 
                                                data-image="<?php echo htmlspecialchars($map['image']); ?>"
                                                data-bs-toggle="modal" data-bs-target="#editMapModal">Sửa</button>

                                        <!-- Xóa bản đồ -->
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="action" value="deleteMap">
                                            <input type="hidden" name="id" value="<?php echo $map['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa bản đồ này?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">Không có bản đồ nào để hiển thị.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Thêm bản đồ mới -->
            <div class="mt-4 text-center">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMapModal">Thêm Bản Đồ Mới</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm Bản Đồ -->
<div class="modal fade" id="addMapModal" tabindex="-1" aria-labelledby="addMapModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMapModalLabel">Thêm Bản Đồ Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="addMap">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="mapName" class="form-label">Tên Bản Đồ</label>
                        <input type="text" class="form-control" id="mapName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="mapImage" class="form-label">Ảnh Bản Đồ</label>
                        <input type="file" class="form-control" id="mapImage" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa Bản Đồ -->
<div class="modal fade" id="editMapModal" tabindex="-1" aria-labelledby="editMapModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMapModalLabel">Sửa Bản Đồ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="editMap">
                <input type="hidden" id="editMapId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editMapName" class="form-label">Tên Bản Đồ</label>
                        <input type="text" class="form-control" id="editMapName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMapImage" class="form-label">Ảnh Bản Đồ (Tùy Chọn)</label>
                        <input type="file" class="form-control" id="editMapImage" name="image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <img id="currentMapImage" src="" alt="Current Map Image" style="width: 100px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.edit-map-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const image = this.dataset.image;

            document.getElementById('editMapId').value = id;
            document.getElementById('editMapName').value = name;
            document.getElementById('currentMapImage').src = '/' + image;
        });
    });

    // Tìm kiếm trong bảng
    document.getElementById('mapSearch').addEventListener('keyup', function() {
        var filter = this.value.toUpperCase();
        var rows = document.getElementById('mapTable').getElementsByTagName('tr');
        
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var mapName = cells[1].textContent || cells[1].innerText;
            rows[i].style.display = mapName.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    });
</script>











<!----------------------------------------------- HERO SECTON ------------------------------------------------------>

<?php
require_once(__DIR__ . "/../../controllers/HeroController.php");

$heroController = new HeroController();
$response = null;

// Xử lý các action POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'addHero':
            ob_start();
            $response = $heroController->addHero();
            $response = ob_get_clean();
            break;
        case 'deleteHero':
            ob_start();
            $response = $heroController->deleteHero();
            $response = ob_get_clean();
            break;
        case 'editHero':
            ob_start();
            $response = $heroController->updateHero();
            $response = ob_get_clean();
            break;
    }

    $response = json_decode($response, true);
}

// Lấy danh sách Heroes
$heroes = $heroController->getAllHeroes();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Heroes</title>
    <link rel="stylesheet" href="/path/to/your/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center text-primary mb-4">Quản Lý Heroes</h3>

    <!-- Hiển thị thông báo -->
    <?php if ($response): ?>
        <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($response['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Quản lý Heroes -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="text-center fw-bold mb-0">Quản Lý Heroes</h5>
        </div>
        <div class="card-body">
            <!-- Thanh tìm kiếm Heroes -->
            <div class="mb-3">
                <input type="text" class="form-control" id="heroSearch" placeholder="Tìm kiếm Heroes...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="heroTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên Hero</th>
                            <th>Loại</th>
                            <th>Giá</th>
                            <th>Ảnh</th>
                            <th>Ngày Tạo</th>
                            <th>Ngày Cập Nhật</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($heroes) > 0): ?>
                            <?php foreach ($heroes as $hero): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($hero['id']); ?></td>
                                    <td><?php echo htmlspecialchars($hero['name']); ?></td>
                                    <td><?php echo htmlspecialchars($hero['type']); ?></td>
                                    <td>$<?php echo number_format($hero['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($hero['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($hero['updated_at']); ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($hero['image']); ?>" 
                                             alt="Hero Image" style="width: 100px;">
                                    </td>
                                    <td>
                                        <!-- Sửa Hero -->
                                        <button class="btn btn-warning btn-sm edit-hero-btn" 
                                                data-id="<?php echo $hero['id']; ?>" 
                                                data-name="<?php echo htmlspecialchars($hero['name']); ?>" 
                                                data-type="<?php echo htmlspecialchars($hero['type']); ?>" 
                                                data-price="<?php echo htmlspecialchars($hero['price']); ?>" 
                                                data-image="<?php echo htmlspecialchars($hero['image']); ?>" 
                                                data-bs-toggle="modal" data-bs-target="#editHeroModal">Sửa</button>

                                        <!-- Xóa Hero -->
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="action" value="deleteHero">
                                            <input type="hidden" name="id" value="<?php echo $hero['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa Hero này?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Không có Heroes nào để hiển thị.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Thêm Hero mới -->
            <div class="mt-4 text-center">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addHeroModal">Thêm Hero Mới</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm Hero -->
<div class="modal fade" id="addHeroModal" tabindex="-1" aria-labelledby="addHeroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHeroModalLabel">Thêm Hero Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="addHero">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="heroName" class="form-label">Tên Hero</label>
                        <input type="text" class="form-control" id="heroName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="heroType" class="form-label">Loại</label>
                        <select class="form-control" id="heroType" name="type" required>
                            <option value="dark">Dark</option>
                            <option value="light">Light</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="heroImage" class="form-label">Ảnh Hero</label>
                        <input type="file" class="form-control" id="heroImage" name="image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="heroPrice" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="heroPrice" name="price" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa Hero -->
<div class="modal fade" id="editHeroModal" tabindex="-1" aria-labelledby="editHeroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHeroModalLabel">Sửa Hero</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="editHero">
                <input type="hidden" id="editHeroId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editHeroName" class="form-label">Tên Hero</label>
                        <input type="text" class="form-control" id="editHeroName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editHeroType" class="form-label">Loại</label>
                        <select class="form-control" id="editHeroType" name="type" required>
                            <option value="dark">Dark</option>
                            <option value="light">Light</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editHeroImage" class="form-label">Ảnh Hero</label>
                        <input type="file" class="form-control" id="editHeroImage" name="image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="editHeroPrice" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="editHeroPrice" name="price" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.edit-hero-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const type = this.dataset.type;
            const price = this.dataset.price;
            const image = this.dataset.image;

            document.getElementById('editHeroId').value = id;
            document.getElementById('editHeroName').value = name;
            document.getElementById('editHeroType').value = type;
            document.getElementById('editHeroPrice').value = price;
        });
    });

    // Tìm kiếm trong bảng
    document.getElementById('heroSearch').addEventListener('keyup', function() {
        var filter = this.value.toUpperCase();
        var rows = document.getElementById('heroTable').getElementsByTagName('tr');
        
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var heroName = cells[1].textContent || cells[1].innerText;
            rows[i].style.display = heroName.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    });
</script>

