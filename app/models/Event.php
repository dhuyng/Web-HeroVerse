<?php
// app/models/Event.php
require_once(__DIR__ . "/../../config/Database.php");
class Event {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function createEvent($title, $description, $start_time, $end_time, $location, $image, $created_by) {
        // Debugging: Log the types and values of the inputs
        // error_log('Title: ' . var_export($title, true));
        // error_log('Description: ' . var_export($description, true));
        // error_log('Start Time: ' . var_export($start_time, true));
        // error_log('End Time: ' . var_export($end_time, true));
        // error_log('Location: ' . var_export($location, true));
        // error_log('Image: ' . var_export($image, true));
        // error_log('Created By: ' . var_export($created_by, true));
    
        $sql = "INSERT INTO events (title, description, start_time, end_time, location, image, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = mysqli_prepare($this->db, $sql);
    
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssss", $title, $description, $start_time, $end_time, $location, $image, $created_by);
    
            if (!($result = mysqli_stmt_execute($stmt))) {
                error_log("Error executing insert event query: " . mysqli_stmt_error($stmt));
                return false;
            }
    
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            error_log("Error preparing statement: " . mysqli_error($this->db));
            return false;
        }
    }

    public function getEvents() {
        $sql = "SELECT id, title, description, start_time, end_time, location, image FROM events ORDER BY start_time DESC";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
            return $result;
        }
        return false;
    }
    
    public function updateEvent($id, $title, $description, $start_time, $end_time, $location, $image, $created_by) {
        $sql = "UPDATE events SET title = ?, description = ?, start_time = ?, end_time = ?, location = ?, image = ?, created_by = ? WHERE id = ?";
    
        $stmt = mysqli_prepare($this->db, $sql);
    
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssi", $title, $description, $start_time, $end_time, $location, $image, $created_by, $id);
    
            if (!($result = mysqli_stmt_execute($stmt))) {
                error_log("Error executing update event query: " . mysqli_stmt_error($stmt));
                return false;
            }
    
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            error_log("Error preparing statement: " . mysqli_error($this->db));
            return false;
        }
    }

    public function deleteEvent($id) {
        // Fetch the event data first to get the image filename
        $sql = "SELECT image FROM events WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $event = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
    
            // If event is found and there is an image, delete the image file
            if ($event && !empty($event['image'])) {
                $imagePath = 'public/img/event/' . $event['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
    
            // Now delete the event from the database
            $deleteSql = "DELETE FROM events WHERE id = ?";
            $deleteStmt = mysqli_prepare($this->db, $deleteSql);
            if ($deleteStmt) {
                mysqli_stmt_bind_param($deleteStmt, 'i', $id);
                mysqli_stmt_execute($deleteStmt);
                mysqli_stmt_close($deleteStmt);
                return true;
            }
        }
        return false;
    }
    
    public function getEventById($id) {
        $sql = "SELECT id, title, description, start_time, end_time, location, image FROM events WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $eventResult = mysqli_stmt_get_result($stmt);
            $event = mysqli_fetch_assoc($eventResult);
            mysqli_stmt_close($stmt);
            return $event;
        }
        return false;
    }

    public function getCommentsByEventId($eventId, $page = 1, $perPage = 5) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT c.*, u.username
        FROM comments c 
        JOIN users u ON c.user_id = u.id
        WHERE c.event_id = ? AND c.status = 'visible'
        ORDER BY c.created_at DESC
        LIMIT ? OFFSET ?";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iii', $eventId, $perPage, $offset);
            mysqli_stmt_execute($stmt);
            $commentsResult = mysqli_stmt_get_result($stmt);
            $comments = mysqli_fetch_all($commentsResult, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
            return $comments;
        }
        return false;
    }

    public function getTotalCommentsCount($eventId) {
        $sql = "SELECT COUNT(*) AS count FROM comments WHERE event_id = ? AND status = 'visible'";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $eventId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $row['count'];
        }
        return 0;
    }

    public function addUserComment($user_id, $event_id, $content) {
        $sql = "INSERT INTO `comments` (`user_id`, `event_id`, `content`) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iis', $user_id, $event_id, $content);
            if (mysqli_stmt_execute($stmt)) {
                $inserted_id = mysqli_insert_id($this->db);
                $fetch_sql = "
                    SELECT c.id, c.content, u.username, c.created_at
                    FROM comments c
                    JOIN users u ON c.user_id = u.id
                    WHERE c.id = ?;
                    ";
                $fetch_stmt = mysqli_prepare($this->db, $fetch_sql);
                if ($fetch_stmt) {
                    mysqli_stmt_bind_param($fetch_stmt, 'i', $inserted_id);
                    mysqli_stmt_execute($fetch_stmt);
                    $result = mysqli_stmt_get_result($fetch_stmt);
                    $comment = mysqli_fetch_assoc($result);
                    mysqli_stmt_close($fetch_stmt);

                    return $comment;
                }
            }
            mysqli_stmt_close($stmt);
        }
        return false;
    }

    public function updateComment($id, $content, $status, $moderated_by) {
        $stmt = mysqli_prepare($this->db, "UPDATE comments SET content = ?, status = ?, moderated_by = ? WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sssi', $content, $status, $moderated_by, $id);
            if (!mysqli_stmt_execute($stmt))
            error_log(mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            return true;
        }
        return false;
    }

}