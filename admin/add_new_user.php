<?php
// Bắt đầu phiên làm việc và kiểm tra quyền truy cập
session_start();
// Kiểm tra xem người dùng đã đăng nhập với quyền admin chưa
if (!isset($_SESSION["admin"])) {
    ?>
    <script type="text/javascript">
        // Nếu chưa đăng nhập, chuyển hướng đến trang index.php
        window.location = "index.php";
    </script>
    <?php
}

// Bao gồm các tệp header và kết nối cơ sở dữ liệu
include "./header.php";
include "conn.php";
?>

<div id="content">
    <div id="content-header">
        <!-- Breadcrumb navigation -->
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-user"></i>
                Add New User</a></div>
    </div>

    <div class="container-fluid">
        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add New User</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <!-- Form để thêm người dùng mới -->
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="First name" name="firstname" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Last name" name="lastname" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">User Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="User name" name="username" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password :</label>
                                <div class="controls">
                                    <input type="password" class="span11" placeholder="Enter Password"
                                        name="password" />
                                </div>
                            </div>

                            <!-- Dropdown chọn vai trò của người dùng -->
                            <div class="control-group">
                                <label class="control-label">select role :</label>
                                <div class="controls">
                                    <select name="role" class="span11">
                                        <option>user</option>
                                        <option>admin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Thông báo lỗi nếu tên người dùng đã tồn tại -->
                            <div class="alert alert-danger" id="error" style="display:none">
                                <strong>This Username Already Exist!</strong> Please try another.
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Save</button>
                            </div>

                            <!-- Thông báo thành công khi thêm người dùng thành công -->
                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Record inserted successfully!</strong>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Bảng hiển thị danh sách người dùng -->
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Username</th>
                                <th>role</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Truy vấn để lấy danh sách người dùng từ cơ sở dữ liệu
                            $res = mysqli_query($link, "SELECT * FROM user_registration");
                            while ($row = mysqli_fetch_array($res)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['firstname'] ?></td>
                                    <td><?php echo $row['lastname'] ?></td>
                                    <td><?php echo $row['username'] ?></td>
                                    <td><?php echo $row['role'] ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td><center><a href="edit_user.php?id=<?php echo $row["id"]?>" style="color:#04D9B2">Edit</a></center></td>
                                    <td><center><a href="delete_user.php?id=<?php echo $row["id"]?> " style="color:red">Delete</a></center></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Kiểm tra xem người dùng đã nhấn nút "Save" chưa
if (isset($_POST["submit1"])) {
    $count = 0;
    // Kiểm tra xem tên người dùng có tồn tại trong cơ sở dữ liệu không
    $res = mysqli_query($link, "SELECT * FROM user_registration WHERE username='$_POST[username]'");
    $count = mysqli_num_rows($res);

    // Nếu tên người dùng đã tồn tại, hiển thị thông báo lỗi
    if ($count > 0) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "block";
            document.getElementById("success").style.display = "none";
        </script>
        <?php
    } else {
        // Nếu tên người dùng chưa tồn tại, thêm người dùng mới vào cơ sở dữ liệu
        mysqli_query($link, "INSERT INTO user_registration VALUES(NULL,'$_POST[firstname]','$_POST[lastname]','$_POST[username]','$_POST[password]','$_POST[role]','active')");
        
        $username_added = $_POST['username'];  // Lấy tên đối tác
        $activity = "Added new User: $username_added";  // Mô tả hoạt động
        mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity')");  // Ghi hoạt động vào bảng recent_activities

        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "none";
            document.getElementById("success").style.display = "block";
            // Sau 1 giây, tải lại trang
            setTimeout(function () {
                window.location.href = window.location.pathname;
            }, 1000);
        </script>
        <?php
    }
}
?>

<?php
// Bao gồm tệp footer
include("./footer.php");
?>
