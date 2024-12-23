<?php

require_once(__DIR__ . '/../models/Hero.php');
require_once(__DIR__ . '/../models/User.php');


class HeroController
{
    private $heroModel;
    private $userModel;  


    public function __construct()
    {
        $this->heroModel = new Hero();
        $this->userModel = new User(); 

    }

    public function getAllHeroes()
    {
        return $this->heroModel->getAllHeroes();
    }

    public function addHero()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $type = $_POST['type'] ?? '';
            $image = $_FILES['image'] ?? null;

            if (empty($name) || empty($type) || !$image || $image['error'] !== UPLOAD_ERR_OK) {
                return ['success' => false, 'message' => 'Dữ liệu không hợp lệ'];
            }

            $uploadDir = __DIR__ . '/../../public/uploads/heroes/';
            $fileName = uniqid('hero_') . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (!move_uploaded_file($image['tmp_name'], $filePath)) {
                return ['success' => false, 'message' => 'Lỗi khi lưu ảnh'];
            }

            $relativePath = 'public/uploads/heroes/' . $fileName;

            if ($this->heroModel->addHero($name, $price, $type, $relativePath)) {
                return ['success' => true, 'message' => 'Thêm Hero thành công'];
            }
        }

        return ['success' => false, 'message' => 'Phương thức không hợp lệ'];
    }

    public function deleteHero()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id || !$this->heroModel->heroExists($id)) {
                return ['success' => false, 'message' => 'Hero không tồn tại'];
            }

            if ($this->heroModel->deleteHero($id)) {
                return ['success' => true, 'message' => 'Xóa Hero thành công'];
            }
        }

        return ['success' => false, 'message' => 'Phương thức không hợp lệ'];
    }

    public function updateHero()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $type = $_POST['type'] ?? '';
            $image = $_FILES['image'] ?? null;

            if (!$id || !$this->heroModel->heroExists($id)) {
                return ['success' => false, 'message' => 'Hero không tồn tại'];
            }

            $imagePath = null;
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/heroes/';
                $fileName = uniqid('hero_') . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                $filePath = $uploadDir . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!move_uploaded_file($image['tmp_name'], $filePath)) {
                    return ['success' => false, 'message' => 'Lỗi khi lưu ảnh'];
                }
                $imagePath = 'public/uploads/heroes/' . $fileName;
            }

            if ($this->heroModel->updateHero($id, $name, $price, $type, $imagePath)) {
                return ['success' => true, 'message' => 'Cập nhật Hero thành công'];
            }
        }

        return ['success' => false, 'message' => 'Phương thức không hợp lệ'];
    }

    public function buyHero($heroId, $heroPrice, $userId) {
        // Kiểm tra nếu các tham số hợp lệ
        if (empty($heroId) || empty($heroPrice) || empty($userId)) {
            return false; // Nếu dữ liệu không hợp lệ, trả về false
        }
    
   
        $userModel = new User();
        $balance = $userModel->getUserBalance($userId);
    
        // Kiểm tra nếu số dư đủ
        if ($balance >= $heroPrice) {
            // Cập nhật số dư của người dùng
            $userModel->updateUserBalance($userId, -$heroPrice);

            // Thêm hero vào danh sách của người dùng
            $userModel->addHeroToUser($userId, $heroId);

            return true; // Thành công
        } else {
            return false; // Nếu số dư không đủ
        }
       
    }
    
    public function checkOwned($userId, $heroId){
        $heroModel = new Hero();
        $check = $heroModel->checkHeroOwnership($userId, $heroId);
        return $check;
    }

    public function getBalance($userId){
        $userModel = new User();
        $balance = $userModel->getUserBalance($userId);
        return (int)$balance;
    }

}
?>
