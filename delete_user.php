<?php
session_start();
require_once 'config.db.php';

header('Content-Type: application/json');

// Kiểm tra kết nối MySQL
if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Lỗi kết nối MySQL: " . mysqli_connect_error()]);
    exit();
}

// Kiểm tra session
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo json_encode(["status" => "error", "message" => "Lỗi: Session không hợp lệ!"]);
    exit();
}

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Bạn không có quyền truy cập!"]);
    exit();
}

// Kiểm tra ID hợp lệ từ POST
if (!isset($_POST['id']) || !is_numeric($_POST['id']) || $_POST['id'] <= 0) {
    echo json_encode(["status" => "error", "message" => "Lỗi: ID không hợp lệ!"]);
    exit();
}

$user_id = (int)$_POST['id'];

try {
    // Kiểm tra xem user có tồn tại không
    $sql = "SELECT id FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Lỗi truy vấn SELECT: " . $conn->error);
    }

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        throw new Exception("Người dùng không tồn tại!");
    }

    // Xóa người dùng
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Lỗi truy vấn DELETE: " . $conn->error);
    }

    $stmt->bind_param('i', $user_id);

    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi xóa người dùng: " . $stmt->error);
    }

    echo json_encode(["status" => "success", "message" => "Xóa người dùng thành công!"]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
