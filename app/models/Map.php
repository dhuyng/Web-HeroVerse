<?php
// /models/Map.php
require_once(__DIR__ . "/../../config/Database.php");
class Map {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();  // Kết nối với cơ sở dữ liệu
    }

    // Lấy tất cả bản đồ từ cơ sở dữ liệu
    public function getAllMaps() {
        $query = "SELECT * FROM map";  // Truy vấn lấy tất cả bản đồ
        $result = mysqli_query($this->db, $query);
        $maps = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $maps[] = $row;
        }

        return $maps;  // Trả về danh sách bản đồ
    }

    // Thêm bản đồ vào cơ sở dữ liệu
    public function addMap($name, $imagePath) {
        $query = "INSERT INTO map (name, image) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $name, $imagePath);

        return $stmt->execute(); // Trả về kết quả thực thi
    }

    // Xóa bản đồ khỏi cơ sở dữ liệu
    public function deleteMap($id) {
        $query = "DELETE FROM map WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);

        return $stmt->execute(); // Trả về kết quả thực thi
    }

    // Kiểm tra xem bản đồ có tồn tại hay không
    public function mapExists($id) {
        $query = "SELECT id FROM map WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0; // Trả về true nếu bản đồ tồn tại
    }

    // Cập nhật thông tin bản đồ
    public function updateMap($id, $name, $imagePath = null) {
        if ($imagePath) {
            // Nếu có ảnh mới
            $query = "UPDATE map SET name = ?, image = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssi', $name, $imagePath, $id);
        } else {
            // Nếu không có ảnh mới
            $query = "UPDATE map SET name = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $name, $id);
        }
        return $stmt->execute(); // Trả về kết quả thực thi
    }

}
?>
