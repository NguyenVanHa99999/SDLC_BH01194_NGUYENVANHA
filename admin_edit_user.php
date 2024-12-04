<?php
include 'db_connection.php';

// Kiểm tra yêu cầu là POST và có đủ dữ liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editUserID'])) {
    $userID = $_POST['editUserID'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $roleID = $_POST['roleID'];

    // Cập nhật thông tin người dùng
    $stmt = $conn->prepare("UPDATE Users SET Username = ?, Email = ?, RoleID = ? WHERE UserID = ?");
    if ($stmt->execute([$username, $email, $roleID, $userID])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating user']);
    }
    exit;
}

// Trả về lỗi nếu truy cập sai phương thức
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
exit;
?>