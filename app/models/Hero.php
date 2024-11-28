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
}
?>
