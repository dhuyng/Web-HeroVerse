<?php

require_once(__DIR__ . "/../../config/Database.php");

class Hero
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllHeroes()
    {
        $query = "SELECT * FROM heroes";
        $result = mysqli_query($this->db, $query);
        $heroes = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $heroes[] = $row;
        }

        return $heroes;
    }

    public function addHero($name, $price, $type, $image)
    {
        $query = "INSERT INTO heroes (name, price, type, image, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sdss', $name, $price, $type, $image);

        return $stmt->execute();
    }

    public function deleteHero($id)
    {
        $query = "DELETE FROM heroes WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);

        return $stmt->execute();
    }

    public function updateHero($id, $name, $price, $type, $image = null)
    {
        if ($image) {
            $query = "UPDATE heroes SET name = ?, price = ?, type = ?, image = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sdssi', $name, $price, $type, $image, $id);
        } else {
            $query = "UPDATE heroes SET name = ?, price = ?, type = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sdsi', $name, $price, $type, $id);
        }

        return $stmt->execute();
    }

    public function heroExists($id)
    {
        $query = "SELECT id FROM heroes WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getHeroById($id)
    {
        $query = "SELECT * FROM heroes WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function checkHeroOwnership($userId, $heroId) {
        // Truy vấn kiểm tra cặp user_id và hero_id trong bảng user_heroes
        $query = "SELECT COUNT(*) FROM user_heroes WHERE user_id = ? AND hero_id = ?";
        $stmt = $this->db->prepare($query);
        
        // Gắn các tham số vào câu truy vấn
        $stmt->bind_param("ii", $userId, $heroId); // 'ii' là kiểu dữ liệu (integer)
        
        // Thực thi câu truy vấn
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result()->fetch_row();  // fetch_row() để lấy kết quả dạng mảng
        
        // Kiểm tra nếu có ít nhất một kết quả (mảng trả về [0] là COUNT(*))
        return $result[0] > 0;
    }
    
}
?>
