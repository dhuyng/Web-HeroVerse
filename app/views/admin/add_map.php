<?php
// /admin/add_map.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $image = $_FILES['image'];

    // Kiểm tra và xử lý ảnh
    if ($image['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/uploads/maps/'; // Thư mục lưu trữ ảnh
        $imageName = basename($image['name']);
        $uploadPath = $uploadDir . $imageName;

        // Kiểm tra nếu thư mục chưa tồn tại, tạo thư mục
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Di chuyển file vào thư mục upload
        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            // Lưu thông tin bản đồ vào cơ sở dữ liệu
            require_once(__DIR__ . "/../../controllers/MapController.php");
            $mapController = new MapController();

            // Kiểm tra kết quả khi thêm bản đồ
            if ($mapController->addMap($name, $uploadPath)) {
                echo "Bản đồ đã được thêm thành công!";
            } else {
                echo "Có lỗi khi lưu bản đồ vào cơ sở dữ liệu.";
            }
        } else {
            echo "Lỗi khi tải ảnh lên!";
        }
    } else {
        echo "Lỗi: " . $image['error'];
    }
}
?>
