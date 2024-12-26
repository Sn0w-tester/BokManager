<?php
session_start();  // Bắt đầu phiên làm việc (session)

if (!isset($_SESSION["admin"])) {  // Kiểm tra xem người dùng có quyền admin hay không
    ?>
    <script type="text/javascript">
        window.location = "index.php";  // Nếu không phải admin, chuyển hướng về trang đăng nhập
    </script>
    <?php
}

include "./header.php";  // Bao gồm header của trang web
include "conn.php";  // Bao gồm file kết nối cơ sở dữ liệu

?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-user"></i>
                Add New Company</a></div> <!-- Breadcrumb điều hướng -->
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add New Company</h5> <!-- Tiêu đề phần thêm công ty -->
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <!-- Nhập tên công ty -->
                            <div class="control-group">
                                <label class="control-label">Company Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Company name..."
                                        name="companyname" />
                                </div>
                            </div>

                            <!-- Thông báo lỗi khi công ty đã tồn tại -->
                            <div class="alert alert-danger" id="error" style="display:none">
                                <strong>This Company Already Exist!</strong> Please try another.
                            </div>

                            <!-- Nút lưu -->
                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Save</button>
                            </div>

                            <!-- Thông báo thành công khi thêm công ty -->
                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Record inserted successfully!</strong>
                            </div>

                        </form>
                    </div>

                </div>

                <!-- Hiển thị danh sách công ty -->
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Company name</th>
                                <th>Edit</th>
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy danh sách công ty từ cơ sở dữ liệu
                            $res = mysqli_query($link, "SELECT * FROM company");
                            while ($row = mysqli_fetch_array($res)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id'] ?></td>
                                    <td><?php echo $row['company_name'] ?></td>
                                    <td>
                                        <center><a href="edit_company.php?id=<?php echo $row["id"] ?>"
                                                style="color:teal">Edit</a></center>
                                    </td>
                                    <td>
                                        <center><a href="delete_company.php?id=<?php echo $row["id"] ?>"
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
// Kiểm tra khi người dùng nhấn nút "Save"
if (isset($_POST["submit1"])) {
    $count = 0;
    // Kiểm tra xem công ty đã tồn tại trong cơ sở dữ liệu chưa
    $res = mysqli_query($link, "SELECT * FROM company WHERE company_name='$_POST[companyname]'");
    $count = mysqli_num_rows($res);

    // Nếu công ty đã tồn tại, hiển thị thông báo lỗi
    if ($count > 0) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "block";  // Hiển thị lỗi
            document.getElementById("success").style.display = "none"; // Ẩn thông báo thành công
        </script>
        <?php
    } else {
        // Nếu công ty chưa tồn tại, thêm công ty mới vào cơ sở dữ liệu
        mysqli_query($link, "INSERT INTO company VALUES(NULL,'$_POST[companyname]')") or die(mysqli_error($link));

        // Thêm hoạt động vào bảng recent_activities
        $company_added = $_POST['companyname'];  // Lấy tên công ty
        $activity = "Added new company: $company_added";  // Mô tả hoạt động
        mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity')");  // Ghi hoạt động vào bảng recent_activities


        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "none";  // Ẩn thông báo lỗi
            document.getElementById("success").style.display = "block"; // Hiển thị thông báo thành công
            setTimeout(function () {
                window.location.href = window.location.pathname;  // Làm mới trang sau 1 giây
            }, 1000);
        </script>
        <?php
    }
}
?>

<?php
include("./footer.php");
?>