<?php
session_start(); // Bắt đầu phiên làm việc để lưu trữ dữ liệu đăng nhập admin
include("conn.php"); // Kết nối cơ sở dữ liệu
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Phần tiêu đề và cấu hình hiển thị -->
    <title>BokManager - Admin login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Liên kết các file CSS để hỗ trợ giao diện -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/matrix-login.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
    <div id="loginbox">
        <!-- Form đăng nhập cho Admin -->
        <form name="form1" class="form-vertical" action="" method="post">
            <!-- Tiêu đề -->
            <div class="control-group normal_text">
                <h3>Admin login</h3>
            </div>
            <!-- Ô nhập Username -->
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                        <input type="text" placeholder="Username" name="username" />
                    </div>
                </div>
            </div>
            <!-- Ô nhập Password -->
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                        <input type="password" placeholder="Password" name="password" />
                    </div>
                </div>
            </div>
            <!-- Nút Submit -->
            <div class="form-actions">
                <center>
                    <input type="submit" name="submit1" value="login" class="btn btn-success col-lg-6">
                </center>
            </div>
        </form>

        <?php
        // Xử lý khi nút "login" được nhấn
        if (isset($_POST["submit1"])) {
            // Lấy và lọc dữ liệu từ input để tránh SQL Injection
            $username = mysqli_real_escape_string($link, $_POST["username"]);
            $password = mysqli_real_escape_string($link, $_POST["password"]);

            $count = 0; // Khởi tạo biến đếm
            // Truy vấn để kiểm tra thông tin admin từ bảng user_registration
            $res = mysqli_query($link, "SELECT * FROM user_registration WHERE username='$username' && password='$password' && role='admin' && status='active' ");
            $count = mysqli_num_rows($res); // Đếm số dòng kết quả

            if ($count > 0) {
                // Nếu đăng nhập thành công
                $_SESSION["admin"] = $username; // Lưu username admin vào session
                ?>
                <script type="text/javascript">
                    window.location = "dashboard.php"; // Chuyển hướng tới trang dashboard
                </script>
                <?php
            } else {
                // Nếu đăng nhập thất bại
                ?>
                <div class="alert alert-danger">
                    <strong>Invalid</strong> username or password.
                </div>
                <?php
            }
        }
        ?>
    </div>

    <!-- Liên kết các file JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/matrix.login.js"></script>
</body>

</html>
