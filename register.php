<?php
// Hiển thị lỗi (chỉ bật khi phát triển)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kết nối cơ sở dữ liệu
include 'db_connection.php';

// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? null;
    $password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT); // Hash mật khẩu
    $roleID = $_POST['roleID'] ?? null;
    $username = strtok($email, '@'); // Lấy phần đầu email làm username
    $firstName = $_POST['firstName'] ?? 'Unknown'; // Giá trị mặc định nếu không nhập
    $lastName = $_POST['lastName'] ?? 'Unknown';  // Giá trị mặc định nếu không nhập

    if ($email && $password && $roleID) {
        try {
            // Chèn dữ liệu vào bảng Users
            $stmt = $conn->prepare("INSERT INTO Users (Username, Email, Password, RoleID, FirstName, LastName) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$username, $email, $password, $roleID, $firstName, $lastName])) {
                header('Location: login.php'); // Điều hướng về trang đăng nhập
                exit;
            } else {
                $error = "Error during registration!";
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill all required fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Register</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
    <div class="mb-3">
        <label for="firstName" class="form-label">First Name</label>
        <input type="text" name="firstName" id="firstName" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="text" name="lastName" id="lastName" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="roleID" class="form-label">Role</label>
        <select name="roleID" id="roleID" class="form-control" required>
            <option value="1">Admin</option>
            <option value="2">Teacher</option>
            <option value="3">Student</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
    <a href="login.php" class="btn btn-link">Login</a>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>