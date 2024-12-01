<?php
// app/controllers/EventController.php
require_once(__DIR__ . '/../models/Event.php');
require_once('app/controllers/BaseController.php');
class EventController extends BaseController{

    public function event() {
        $eventModel = new Event();
        $events = $eventModel->getEvents();
        if ($events) {
            $this->renderEventPage('event', ['events' => $events]);
        }
        else echo 'No events';
    }

    public function event_item() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $eventId = $_GET['item'] ?? null; 
            if ($eventId) {
                $eventModel = new Event();
                $event = $eventModel->getEventById($eventId);
                if ($event) {
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $commentsPerPage = 5;
                    $comments = $eventModel->getCommentsByEventId($eventId, $page, $commentsPerPage);
                    $totalComments = $eventModel->getTotalCommentsCount($eventId);
                    $totalPages = ceil($totalComments / $commentsPerPage);

                    $this->renderEvent('template_1', [
                        'title' => $event['title'],
                        'event' => $event,
                        'comments' => $comments,
                        'currentPage' => $page,
                        'totalPages' => $totalPages,
                    ]);
                } else {
                    echo 'Failed to get event details or event deleted.';
                }
            } else {
                echo 'Missing event ID.';
            }
        } else {
            echo 'Invalid request method.';
        }
    }
    

    public function createEvent() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = ['success' => false, 'message' => ''];

            $title = $_POST['title'];
            $description = $_POST['description'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $location = $_POST['location'];
            $banner = $_FILES['banner'] ?? null;
            $created_by = $_SESSION['user']['username'];

            // Handle file upload
            $uploadedFileName = null;
            if ($banner && $banner['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/img/event/';
                if (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0755, true)) {
                        $response['message'] = 'Không thể tạo thư mục để tải ảnh lên.';
                        echo json_encode($response);
                        exit;
                    }
                }
                $uploadedFileName = uniqid('profile_', true) . '.' . pathinfo($banner['name'], PATHINFO_EXTENSION);
                $uploadFilePath = $uploadDir . $uploadedFileName;

                if (!move_uploaded_file($banner['tmp_name'], $uploadFilePath)) {
                    $response['message'] = 'Không thể tải lên ảnh event.';
                    echo json_encode($response);
                    exit;
                }

            } elseif ($banner && $banner['error'] !== UPLOAD_ERR_NO_FILE) {
                $response['message'] = 'Có lỗi xảy ra khi tải lên ảnh event.';
                echo json_encode($response);
                exit;
            }

            $eventModel = new Event();

            $result = $eventModel->createEvent($title, $description, $start_time, $end_time, $location, $uploadedFileName, $created_by);
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Event added successfully.';
            } else {
                $response['message'] = 'Failed to add event.';
            }

            echo json_encode($response);
            exit;
        }
    }

    public function getEvents() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventModel = new Event();
            $events = $eventModel->getEvents();
            if ($events) {
                echo json_encode(['success' => true, 'data' => $events]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to get events.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }
    
    public function updateEvent() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = ['success' => false, 'message' => ''];

            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $location = $_POST['location'];
            $banner = $_FILES['banner'] ?? null;
            $oldBanner = $_POST['oldBanner'];
            $updated_by = $_SESSION['user']['username'];

            // Handle file upload
            $uploadedFileName = null;
            if ($banner && $banner['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/img/event/';
                if (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0755, true)) {
                        $response['message'] = 'Không thể tạo thư mục để tải ảnh lên.';
                        echo json_encode($response);
                        exit;
                    }
                }
                $uploadedFileName = uniqid('profile_', true) . '.' . pathinfo($banner['name'], PATHINFO_EXTENSION);
                $uploadFilePath = $uploadDir . $uploadedFileName;

                if (!move_uploaded_file($banner['tmp_name'], $uploadFilePath)) {
                    $response['message'] = 'Không thể tải lên ảnh event.';
                    echo json_encode($response);
                    exit;
                }
                
                // Delete the old event picture if exists
                if (!empty($oldBanner)) {
                    $oldFilePath = $uploadDir . $oldBanner;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            } elseif ($banner && $banner['error'] !== UPLOAD_ERR_NO_FILE) {
                $response['message'] = 'Có lỗi xảy ra khi tải lên ảnh event.';
                echo json_encode($response);
                exit;
            } elseif ($banner['error'] === UPLOAD_ERR_NO_FILE) {
                $uploadedFileName = $oldBanner;
            }

            $eventModel = new Event();

            $result = $eventModel->updateEvent($id, $title, $description, $start_time, $end_time, $location, $uploadedFileName, $updated_by);
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Event updated successfully.';
            } else {
                $response['message'] = 'Failed to update event.';
            }

            echo json_encode($response);
            exit;
        }
    }

    public function deleteEvent() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = json_decode(file_get_contents("php://input"), true)['id'];
            $eventModel = new Event();
            $result = $eventModel->deleteEvent($id);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Deleted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to get events.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

    public function addComment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true); 
            $eventModel = new Event();
            $result = $eventModel->addUserComment($data['user_id'], $data['event_id'], $data['comment']);
            if ($result) {
                echo json_encode(['success' => true, 'comment' => $result]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed: your comment was not uploaded.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

    public function getComments() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $eventId = $_GET['item'] ?? null;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $commentsPerPage = 5;
    
            if ($eventId) {
                $eventModel = new Event();
                $comments = $eventModel->getCommentsByEventId($eventId, $page, $commentsPerPage);
                $totalComments = $eventModel->getTotalCommentsCount($eventId);
                $totalPages = ceil($totalComments / $commentsPerPage);
    
                echo json_encode([
                    'comments' => $comments,
                    'currentPage' => $page,
                    'totalPages' => $totalPages,
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Missing event ID.']);
            }
            exit;
        }
    }

    public function editComment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $eventModel = new Event();
            $result = $eventModel->updateComment($data['id'], $data['content'], $data['status'], $_SESSION['user']['id']);
            echo json_encode(['success' => $result]);
        }
    }
    
}