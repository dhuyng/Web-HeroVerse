<?php
// app/controllers/AuthController.php
require_once('BaseController.php');
require_once(__DIR__ . '/../models/User.php');
class AuthController extends BaseController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $role = trim($_POST['role']);
            
            if ($this->validateRegistrationData($username, $email, $password)) {
                $userModel = new User();
                $result = $userModel->register($username, $email, $password, $role);

                if ($result) {
                    header("Location: login");
                    exit();
                } else {
                    $_SESSION['error'] = "Registration failed!";
                    $this->render('register', 'Register - HeroVerse');
                }
            }
        } else {
            $this->render('register', 'Register - HeroVerse');
        }
    }

    private function validateRegistrationData($username, $email, $password) {
        // Add validation rules (e.g., check if username is already taken, etc.)
        return true;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check Anti-CSRF token
            if (!checkToken($_POST['user_token'], $_SESSION['session_token'], 'info')) {
                echo json_encode(['success' => false, 'message' => 'CSRF token is incorrect']);
                exit();
            }
    
            $username = stripslashes(trim($_POST['username']));
            $password = stripslashes($_POST['password']);
            $total_failed_login = 3;
            $lockout_time = 15; // in minutes
            $userModel = new User();
    
            $user = $userModel->getUserByUsername($username);
    
            if ($user) {
                // Check if account is locked
                if ($user['failed_login'] >= $total_failed_login) {
                    $lastLogin = strtotime($user['last_login']);
                    $timeout = $lastLogin + ($lockout_time * 60);
                    if (time() < $timeout) {
                        echo json_encode(['success' => false, 'message' => 'Account is locked. Please try again later.']);
                        exit();
                    }
                }
    
                // Verify password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = $user;
                    $_SESSION['logged_in'] = true;
    
                    // Reset failed login attempts
                    $userModel->resetFailedLogin($username);
    
                    $redirect = $user['role'] === 'admin' ? 'dashboard' : 'home';
                    echo json_encode(['success' => true, 'redirect' => $redirect]);
                    exit();
                } else {
                    $userModel->incrementFailedLogin($username);
                }
            }
    
            echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
        }
    }

    public function unlockAccount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = stripslashes(trim($_POST['username']));
            $userModel = new User();
            // Reset failed login attempts
            $userModel->resetFailedLogin($username);
            echo json_encode(['success' => true, 'message' => 'Account unlocked!']);
        }
    }
    

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: login");
        exit();
    }
    
    public function verifyCurrentPassword() {
        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the current user ID from session
            $userId = $_SESSION['user']['id'];
            
            // Get the current password from the request payload (JSON)
            $data = json_decode(file_get_contents("php://input"), true);
            // Check Anti-CSRF token
	        if (!checkToken( $data[ 'user_token' ], $_SESSION[ 'session_token' ], 'info' )) {
                echo json_encode(['success' => false, 'message' => 'CSRF token is incorrect']);
                exit();
            }
            $currentPassword = $data['password'];
            
            // Create the user model instance
            $userModel = new User();
            // Verify the current password
            $isPasswordValid = $userModel->verifyCurrentPassword($userId, $currentPassword);

            // Return JSON response
            echo json_encode(['success' => $isPasswordValid]);
        } else {
            // If not an AJAX request, return an error or render a view
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

    public function updateUserInfo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = ['success' => false, 'message' => ''];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $newPassword = $_POST['newPassword'] ?? null;
            $confirmPassword = $_POST['confirmPassword'] ?? null;
            $twoFA = isset($_POST['2fa']) ? 1 : 0;
            $profilePic = $_FILES['profile_pic'] ?? null;
    
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = 'Địa chỉ email không hợp lệ.';
                echo json_encode($response);
                exit();
            }
    
            // Validate password
            if ($newPassword && $newPassword !== $confirmPassword) {
                $response['message'] = 'Mật khẩu mới và xác nhận mật khẩu không khớp.';
                echo json_encode($response);
                exit();
            }
    
            // Handle file upload with enhanced security
            $uploadedFileName = null;
            if ($profilePic && $profilePic['error'] === UPLOAD_ERR_OK) {
                $uploadedName = $profilePic['name'];
                $uploadedExt = strtolower(pathinfo($uploadedName, PATHINFO_EXTENSION));
                $uploadedSize = $profilePic['size'];
                $uploadedType = $profilePic['type'];
                $uploadedTmp = $profilePic['tmp_name'];
    
                // Allowed extensions and MIME types
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $allowedTypes = ['image/jpeg', 'image/png'];
    
                if (in_array($uploadedExt, $allowedExtensions) &&
                    in_array($uploadedType, $allowedTypes) &&
                    $uploadedSize < 10000000 && // Limit size to 10 MB
                    getimagesize($uploadedTmp)) {
    
                    // Generate secure file name and temporary path
                    $tempFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . md5(uniqid() . $uploadedName) . '.' . $uploadedExt;
                    $uploadDir = 'public/img/avatar/';
                    $uploadedFileName = md5(uniqid() . $uploadedName) . '.' . $uploadedExt;
                    $uploadFilePath = $uploadDir . $uploadedFileName;
    
                    // Strip metadata and re-encode the image
                    if ($uploadedType === 'image/jpeg') {
                        $img = imagecreatefromjpeg($uploadedTmp);
                        imagejpeg($img, $tempFile, 100);
                    } else {
                        $img = imagecreatefrompng($uploadedTmp);
                        imagepng($img, $tempFile, 9);
                    }
                    imagedestroy($img);
    
                    // Move the sanitized file to the target directory
                    if (!is_dir($uploadDir)) {
                        if (!mkdir($uploadDir, 0755, true)) {
                            $response['message'] = 'Không thể tạo thư mục để tải ảnh lên.';
                            echo json_encode($response);
                            exit();
                        }
                    }
                    if (!rename($tempFile, $uploadFilePath)) {
                        $response['message'] = 'Không thể tải lên ảnh đại diện.';
                        echo json_encode($response);
                        exit();
                    }
    
                    // Delete old profile picture
                    if (!empty($_SESSION['user']['profile_pic'])) {
                        $oldFilePath = $uploadDir . $_SESSION['user']['profile_pic'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                } else {
                    $response['message'] = 'Ảnh đại diện không hợp lệ. Chỉ chấp nhận JPEG hoặc PNG dưới 10MB.';
                    echo json_encode($response);
                    exit();
                }
            } elseif ($profilePic && $profilePic['error'] !== UPLOAD_ERR_NO_FILE) {
                $response['message'] = 'Có lỗi xảy ra khi tải lên ảnh đại diện.';
                echo json_encode($response);
                exit();
            }
    
            // Update user info
            $userId = $_SESSION['user']['id'];
    
            $userModel = new User();
            $updateSuccess = $userModel->updateUserInfo($userId, $email, $newPassword, $uploadedFileName, $twoFA);
    
            if ($updateSuccess) {
                // Update session data
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['profile_pic'] = $uploadedFileName ?: $_SESSION['user']['profile_pic'];
                $_SESSION['user']['two_fa_enabled'] = $twoFA;
    
                $response['success'] = true;
                $response['message'] = 'Cập nhật thông tin thành công.';
            } else {
                $response['message'] = 'Cập nhật thông tin thất bại.';
            }
    
            echo json_encode($response);
            exit();
        }
    }
    
    
    public function updateAdminInfo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = ['success' => false, 'message' => ''];
            $newPassword = $_POST['newPassword'] ?? null;
            $confirmPassword = $_POST['confirmPassword'] ?? null;
            $profilePic = $_FILES['profile_pic'] ?? null;

            // Validate password
            if ($newPassword && $newPassword !== $confirmPassword) {
                $response['message'] = 'Mật khẩu mới và xác nhận mật khẩu không khớp.';
                echo json_encode($response);
                exit;
            }

            // Handle file upload with enhanced security
            $uploadedFileName = null;
            if ($profilePic && $profilePic['error'] === UPLOAD_ERR_OK) {
                $uploadedName = $profilePic['name'];
                $uploadedExt = strtolower(pathinfo($uploadedName, PATHINFO_EXTENSION));
                $uploadedSize = $profilePic['size'];
                $uploadedType = $profilePic['type'];
                $uploadedTmp = $profilePic['tmp_name'];
    
                // Allowed extensions and MIME types
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $allowedTypes = ['image/jpeg', 'image/png'];
    
                if (in_array($uploadedExt, $allowedExtensions) &&
                    in_array($uploadedType, $allowedTypes) &&
                    $uploadedSize < 10000000 && // Limit size to 10 MB
                    getimagesize($uploadedTmp)) {
    
                    // Generate secure file name and temporary path
                    $tempFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . md5(uniqid() . $uploadedName) . '.' . $uploadedExt;
                    $uploadDir = 'public/img/avatar/';
                    $uploadedFileName = md5(uniqid() . $uploadedName) . '.' . $uploadedExt;
                    $uploadFilePath = $uploadDir . $uploadedFileName;
    
                    // Strip metadata and re-encode the image
                    if ($uploadedType === 'image/jpeg') {
                        $img = imagecreatefromjpeg($uploadedTmp);
                        imagejpeg($img, $tempFile, 100);
                    } else {
                        $img = imagecreatefrompng($uploadedTmp);
                        imagepng($img, $tempFile, 9);
                    }
                    imagedestroy($img);
    
                    // Move the sanitized file to the target directory
                    if (!is_dir($uploadDir)) {
                        if (!mkdir($uploadDir, 0755, true)) {
                            $response['message'] = 'Không thể tạo thư mục để tải ảnh lên.';
                            echo json_encode($response);
                            exit();
                        }
                    }
                    if (!rename($tempFile, $uploadFilePath)) {
                        $response['message'] = 'Không thể tải lên ảnh đại diện.';
                        echo json_encode($response);
                        exit();
                    }
    
                    // Delete old profile picture
                    if (!empty($_SESSION['user']['profile_pic'])) {
                        $oldFilePath = $uploadDir . $_SESSION['user']['profile_pic'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                } else {
                    $response['message'] = 'Ảnh đại diện không hợp lệ. Chỉ chấp nhận JPEG hoặc PNG dưới 10MB.';
                    echo json_encode($response);
                    exit();
                }
            } elseif ($profilePic && $profilePic['error'] !== UPLOAD_ERR_NO_FILE) {
                $response['message'] = 'Có lỗi xảy ra khi tải lên ảnh đại diện.';
                echo json_encode($response);
                exit();
            }

            // Update user info
            $userId = $_SESSION['user']['id']; 

            $userModel = new User(); 
            $updateSuccess = $userModel->updateAdminInfo($userId, $newPassword, $uploadedFileName);

            if ($updateSuccess) {
                // Update session data
                $_SESSION['user']['profile_pic'] = $uploadedFileName ?: $_SESSION['user']['profile_pic'];

                $response['success'] = true;
                $response['message'] = 'Cập nhật thông tin thành công.';
            } else {
                $response['message'] = 'Cập nhật thông tin thất bại.';
            }

            echo json_encode($response);
            exit;
        }
    }

    public function getTransactionHistory() {
        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user']['id'])) {
                echo json_encode(['success' => false, 'message' => 'User not logged in']);
                return;
            }
            
            $userId = $_SESSION['user']['id'];
    
            // Create the user model instance
            $userModel = new User();
    
            // Fetch transaction history
            $data = $userModel->getTransactionHistory($userId);
    
            // Return JSON response
            if ($data) {
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No transaction history found']);
            }
        } else {
            // If not an AJAX request, return an error
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

    public function generate_qr() {
        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true); // Get JSON payload
            $method = $input['method'];
            $price = $input['price'];
    
            require_once('public/lib/phpqrcode/phpqrcode.php');
    
            // Generate QR Code data (replace this with API data if needed)
            $data = ($method === 'momo')
                ? "https://momo.com/payment?amount=$price"
                : "https://zalopay.com/payment?amount=$price";
    
            // Start output buffering to capture the image
            ob_start();
            QRcode::png($data); // Generate QR code image directly into the buffer
            $imageData = base64_encode(ob_get_contents()); // Get buffered content and encode it in base64
            ob_end_clean(); // Clean up the buffer
    
            // Respond with the base64 data
            echo json_encode(['qrData' => 'data:image/png;base64,' . $imageData]);
        } else {
            // If not an AJAX request, return an error
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }
    public function userManager() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $users = $userModel->getAllUsers();
            if($users) {
                echo json_encode(['success' => true, 'data' => $users]);
            }
            else{
                echo json_encode(['success' => false, 'message' => 'Error fetching users']);
            }
            
        }
        else {
        
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
    
}

    public function getAllSupports() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $supports = $userModel->getAllSupports();
            if ($supports) {
                echo json_encode(['success' => true, 'data' => $supports]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error fetching support requests']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }   
    }

    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = ['success' => false, 'message' => ''];


            // Get the current password from the request payload (JSON)
            $data = json_decode(file_get_contents("php://input"), true);
            $userId = $data['id'];
            error_log('-------------POST: ' . print_r($_POST, true));
            error_log('-------------User ID: ' . $userId);

            if (!$userId) {
                $response['message'] = 'User ID is required.';
                echo json_encode($response);
                exit;
            }

            $userModel = new User();
            $deleteSuccess = $userModel->deleteUser($userId);

            if ($deleteSuccess) {
                $response['success'] = true;
                $response['message'] = 'User deleted successfully.';
            } else {
                $response['message'] = 'Failed to delete user.';
            }

            echo json_encode($response);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

    public function deleteSupport() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = ['success' => false, 'message' => ''];

            // Get the support ID from the request payload (JSON)
            $data = json_decode(file_get_contents("php://input"), true);
            $supportId = $data['id'];


            if (!$supportId) {
                $response['message'] = 'Support ID is required.';
                echo json_encode($response);
                exit;
            }

            $userModel = new User();
            $deleteSuccess = $userModel->deleteSupport($supportId);

            if ($deleteSuccess) {
                $response['success'] = true;
                $response['message'] = 'Support request deleted successfully.';
            } else {
                $response['message'] = 'Failed to delete support request.';
            }

            echo json_encode($response);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

    public function toggleSupportStatus(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = ['success' => false, 'message' => ''];



            // Get the support ID from the request payload (JSON)
            $data = json_decode(file_get_contents("php://input"), true);
            $supportId = $data['id'];
            $userId = $_SESSION['user']['id'];

            if (!$supportId) {
                $response['message'] = 'Support ID is required.';
                echo json_encode($response);
                exit;
            }

            $userModel = new User();
            $toggleSuccess = $userModel->toggleSupportStatus($supportId, $userId);
            $userInfo = $userModel->getUserById($userId);

            error_log('-------------toggleSuccess: ' . $toggleSuccess);

            if ($toggleSuccess) {
                $response['success'] = true;
                $response['data'] = ['username' => $userInfo['username'], 'email' => $userInfo['email']];
                $response['message'] = 'Support request status updated successfully.';
            } else {
                $response['message'] = 'Failed to update support request status.';
            }

            echo json_encode($response);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

    public function updateUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = ['success' => false, 'message' => ''];

            // Get the user ID from the request payload (JSON)
            $data = json_decode(file_get_contents("php://input"), true);
            $userId = $data['id'];
            $username = $data['username'];
            $email = $data['email'];
            $role = $data['role'];
            $subscription = $data['subscription'];

            error_log('-------------Information: ' . $userId . ' ' . $username . ' ' . $email . ' ' . $role . ' ' . $subscription);


            if (!$userId) {
                $response['message'] = 'User ID is required.';
                echo json_encode($response);
                exit;
            }

            if (!$username) {
                $response['message'] = 'Username is required.';
                echo json_encode($response);
                exit;
            }

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = 'Địa chỉ email không hợp lệ.';
                echo json_encode($response);
                exit;
            }

            // Validate role
            if (!in_array($role, ['Member', 'admin'])) {
                $response['message'] = 'Role is invalid.';
                echo json_encode($response);
                exit;
            }

            // Validate subscription
            if (!in_array($subscription, ['basic', 'premium', 'pro'])) {
                $response['message'] = 'Subscription is invalid.';
                echo json_encode($response);
                exit;
            }


            $userModel = new User();
            $updateSuccess = $userModel->updateUser($userId, $username, $email, $role, $subscription);

            if ($updateSuccess) {
                $response['success'] = true;
                $response['message'] = 'User role updated successfully.';
            } else {
                $response['message'] = 'Failed to update user role.';
            }

            echo json_encode($response);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }
    
}
