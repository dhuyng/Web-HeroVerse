<?php
// /controllers/MapController.php

require_once(__DIR__ . '/../models/Map.php');

class MapController {
    private $mapModel;

    public function __construct() {
        $this->mapModel = new Map();  // Khởi tạo model Map
    }

    // Lấy tất cả bản đồ
    public function getAllMaps() {
        return $this->mapModel->getAllMaps();  // Trả về danh sách bản đồ
    }

    // Thêm bản đồ mới
    public function addMap() {
        $response = ['success' => false, 'message' => ''];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $image = $_FILES['image'] ?? null;

            if (empty($name)) {
                $response['message'] = 'Tên bản đồ không được để trống.';
                echo json_encode($response);
                return;
            }

            if (!$image || $image['error'] !== UPLOAD_ERR_OK) {
                $response['message'] = 'Lỗi tải lên ảnh bản đồ.';
                echo json_encode($response);
                return;
            }

            // Xử lý lưu ảnh
            $uploadDir = __DIR__ . '/../../public/uploads/maps/';
            $fileName = uniqid('map_') . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (!move_uploaded_file($image['tmp_name'], $filePath)) {
                $response['message'] = 'Lỗi khi lưu file ảnh.';
                echo json_encode($response);
                return;
            }

            // Thêm bản đồ vào cơ sở dữ liệu
            $relativePath = 'public/uploads/maps/' . $fileName;
            if ($this->mapModel->addMap($name, $relativePath)) {
                $response['success'] = true;
                $response['message'] = 'Bản đồ đã được thêm thành công.';
            } else {
                $response['message'] = 'Lỗi khi thêm bản đồ vào cơ sở dữ liệu.';
            }
        } else {
            $response['message'] = 'Phương thức không hợp lệ.';
        }

        echo json_encode($response);
    }

    // Xóa bản đồ
    public function deleteMap() {
        $response = ['success' => false, 'message' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id || !$this->mapModel->mapExists($id)) {
                $response['message'] = 'Bản đồ không tồn tại.';
                echo json_encode($response);
                return;
            }

            if ($this->mapModel->deleteMap($id)) {
                $response['success'] = true;
                $response['message'] = 'Bản đồ đã được xóa thành công.';
            } else {
                $response['message'] = 'Lỗi khi xóa bản đồ.';
            }
        } else {
            $response['message'] = 'Phương thức không hợp lệ.';
        }

        echo json_encode($response);
    }


    // Sửa thông tin bản đồ
    public function updateMap() {
        $response = ['success' => false, 'message' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $image = $_FILES['image'] ?? null;

            if (!$id || !$this->mapModel->mapExists($id)) {
                $response['message'] = 'Bản đồ không tồn tại.';
                echo json_encode($response);
                return;
            }

            if (empty($name)) {
                $response['message'] = 'Tên bản đồ không được để trống.';
                echo json_encode($response);
                return;
            }

            $imagePath = null;
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                // Xử lý lưu ảnh mới
                $uploadDir = __DIR__ . '/../../public/uploads/maps/';
                $fileName = uniqid('map_') . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                $filePath = $uploadDir . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!move_uploaded_file($image['tmp_name'], $filePath)) {
                    $response['message'] = 'Lỗi khi lưu file ảnh.';
                    echo json_encode($response);
                    return;
                }
                $imagePath = 'public/uploads/maps/' . $fileName;
            }

            if ($this->mapModel->updateMap($id, $name, $imagePath)) {
                $response['success'] = true;
                $response['message'] = 'Bản đồ đã được cập nhật thành công.';
            } else {
                $response['message'] = 'Lỗi khi cập nhật bản đồ.';
            }
        } else {
            $response['message'] = 'Phương thức không hợp lệ.';
        }

        echo json_encode($response);
    }

}
?>
