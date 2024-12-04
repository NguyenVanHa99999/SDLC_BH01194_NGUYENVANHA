<?php
session_start();
if (!isset($_SESSION['RoleID'])) {
    header('Location: login.php');
    exit;
}

$roleID = $_SESSION['RoleID']; // RoleID từ cơ sở dữ liệu
$username = $_SESSION['Username'] ?? 'User'; // Lấy tên người dùng từ session nếu có
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-brand img {
            width: 40px;
            height: auto;
        }

        .sidebar {
            height: 1000px;
            background-color: #6c757d;
            padding: 15px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

        .content {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logout {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark" style="background-color: #6c757d; padding: 20px;">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4K-tjpKQ_HjUjmO_g2VBQqIfvzd59QHPHSg&s" alt="Logo" style="height: 60px; margin-right: 20px;">
            <span style="font-size: 32px; color: white;">Student Management System</span>
        </div>
        <div class="text-white" style="font-size: 18px; margin-left: auto;">
            Hello, <?= htmlspecialchars($username); ?>!
        </div>
    </div>
</nav>


            <div class="text-white" style="font-size: 18px;">Welcome, <?= htmlspecialchars($username); ?>!</div>
        </div>
    </nav>


    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <?php if ($roleID == 1): ?>
                    <h4 class="text-white" style="text-align: center; font-weight: bold; font-size: 3.5em;">Admin</h4>

                    <a href="?page=manage_users">Manage Users</a>
                    <a href="?page=manage_classes">Manage Classes</a>
                    <a href="?page=manage_subjects">Manage Subjects</a>
                    <a href="?page=manage_sessions">Manage Session</a>
                    <a href="?page=manage_attendance">Manage Attendance</a>
                <?php elseif ($roleID == 2): ?>
                    <h4 class="text-white" style="text-align: center; font-weight: bold; font-size: 3.5em;">Teacher</h4>
                    <a href="?page=teaching_schedule">View Teaching Schedule</a>
                    <a href="?page=session_details">View Session Details</a>
                    <a href="?page=attendance_management">Manage Attendance</a>
                <?php elseif ($roleID == 3): ?>
                    <h4 class="text-white" style="text-align: center; font-weight: bold; font-size: 3.5em;">Student</h4>
                    <a href="?page=view_subjects">View Subjects</a>
                    <a href="?page=view_attendance">View Attendance</a>
                    <a href="?page=register_classes">Register for Classes</a>
                <?php endif; ?>
                <div class="logout">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-9">
                <div class="content">
                    <?php
                    // Hiển thị nội dung dựa trên vai trò và nút được nhấn
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        if ($roleID == 1) {
                            if ($page == 'manage_users') {
                                include 'admin_users.php';
                            } elseif ($page == 'manage_classes') {
                                include 'admin_classes.php';
                            } elseif ($page == 'manage_subjects') {
                                include 'admin_subjects.php';
                            } elseif ($page == 'manage_sessions') {
                                include 'admin_sessions.php'; // Tạo file này trong bước tiếp theo

                            } elseif ($page == 'manage_attendance') {
                                include 'admin_attendance.php';
                            }
                        } elseif ($roleID == 2) {
                            if ($page == 'teaching_schedule') {
                                include 'teacher_schedule.php';
                            } elseif ($page == 'session_details') {
                                include 'teacher_session.php';
                            } elseif ($page == 'attendance_management') {
                                include 'teacher_attendance.php';
                            }
                        } elseif ($roleID == 3) {
                            if ($page == 'view_subjects') {
                                include 'student_subjects.php';
                            } elseif ($page == 'view_attendance') {
                                include 'student_attendance.php';
                            } elseif ($page == 'register_classes') {
                                include 'student_register_classes.php';
                            }
                        } else {
                            echo "<h5 class='text-danger'>Access Denied!</h5>";
                        }
                    } else {
                        echo "<h4>Welcome to the Dashboard</h4>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>