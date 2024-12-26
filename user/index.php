<?php
session_start(); // Bắt đầu phiên làm việc (session) để lưu trữ dữ liệu người dùng đăng nhập
include("../admin/conn.php"); // Kết nối cơ sở dữ liệu bằng cách include file kết nối
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Phần tiêu đề và metadata của trang -->
    <title>BokManager - Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Link các file CSS cho giao diện -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/matrix-login.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
    <div id="loginbox">
        <!-- Form đăng nhập -->
        <form name="form1" class="form-vertical" action="" method="post">
            <div class="control-group normal_text">
                <!-- Tiêu đề trang login -->
                <h3>Login Page</h3>
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
            <!-- Nút Submit để gửi form -->
            <div class="form-actions">
                <center>
                    <input type="submit" name="submit1" value="login" class="btn btn-success col-lg-6">
                </center>
            </div>
        </form>

        <?php
        // Xử lý khi người dùng nhấn nút "login"
        if (isset($_POST["submit1"])) {
            // Lấy và xử lý dữ liệu nhập từ người dùng để tránh SQL Injection
            $username = mysqli_real_escape_string($link, $_POST["username"]);
            $password = mysqli_real_escape_string($link, $_POST["password"]);

            $count = 0; // Khởi tạo biến đếm
            // Truy vấn kiểm tra thông tin đăng nhập trong bảng user_registration
            $res = mysqli_query($link, "SELECT * FROM user_registration WHERE username='$username' && password='$password' && status='active' ");
            $count = mysqli_num_rows($res); // Đếm số bản ghi trả về

            if ($count > 0) {
                // Nếu đăng nhập thành công
                $_SESSION["user"] = $username; // Lưu username vào session
                ?>
                <script type="text/javascript">
                    window.location = "dashboard.php"; // Chuyển hướng tới trang dashboard
                </script>
                <?php
            } else {
                // Nếu thông tin không đúng hoặc tài khoản bị khóa
                ?>
                <div class="alert alert-danger">
                    <strong>Invalid</strong> username or password. Or account blocked by admin.
                </div>
                <?php
            }
        }
        ?>
    </div>

    <!-- Link các file JavaScript để hỗ trợ giao diện và logic -->
    <script src="js/jquery.min.js"></script>
    <script src="js/matrix.login.js"></script>
</body>

</html>
