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
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-user"></i>
                Add New Unit</a></div>
    </div>

    <div class="container-fluid">
        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add New Unit</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <!-- Form để thêm đơn vị mới -->
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Unit Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="unit name" name="unitname" />
                                </div>
                            </div>

                            <!-- Thông báo lỗi nếu đơn vị đã tồn tại -->
                            <div class="alert alert-danger" id="error" style="display:none">
                                <strong>This Unit Already Exist!</strong> Please try another.
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Save</button>
                            </div>

                            <!-- Thông báo thành công khi thêm đơn vị thành công -->
                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Record inserted successfully!</strong>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Bảng hiển thị các đơn vị đã có -->
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Unit name</th>
                                <th>Edit</th>
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Truy vấn để lấy danh sách các đơn vị từ cơ sở dữ liệu
                            $res = mysqli_query($link, "SELECT * FROM unit");
                            while ($row = mysqli_fetch_array($res)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id'] ?></td>
                                    <td><?php echo $row['units'] ?></td>
                                    <td>
                                        <center><a href="edit_unit.php?id=<?php echo $row["id"] ?>"
                                                style="color:teal">Edit</a></center>
                                    </td>
                                    <td>
                                        <center><a href="delete_unit.php?id=<?php echo $row["id"] ?>"
                                                style="color:red">Delete</a></center>
                                    </td>
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
    // Kiểm tra xem đơn vị có tồn tại trong cơ sở dữ liệu hay không
    $res = mysqli_query($link, "SELECT * FROM unit WHERE units='$_POST[unitname]'");
    $count = mysqli_num_rows($res);

    // Nếu đơn vị đã tồn tại, hiển thị thông báo lỗi
    if ($count > 0) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "block";
            document.getElementById("success").style.display = "none";
        </script>
        <?php
    } else {
        // Nếu đơn vị chưa tồn tại, thêm vào cơ sở dữ liệu
        mysqli_query($link, "INSERT INTO unit VALUES(NULL,'$_POST[unitname]')") or die(mysqli_error($link));

        $unit_added = $_POST['unitname'];  // Lấy tên đối tác
        $activity = "Added new Unit: $unit_added";  // Mô tả hoạt động
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