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
                Add New Categories</a></div>  <!-- Breadcrumb điều hướng -->
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add New Categories</h5>  <!-- Tiêu đề phần thêm danh mục -->
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <!-- Nhập tên danh mục -->
                            <div class="control-group">
                                <label class="control-label">Category Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Category name" name="categoryname" />
                                </div>
                            </div>

                            <!-- Thông báo lỗi khi danh mục đã tồn tại -->
                            <div class="alert alert-danger" id="error" style="display:none">
                                <strong>This Category Already Exist!</strong> Please try another.
                            </div>

                            <!-- Nút lưu -->
                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Save</button>
                            </div>

                            <!-- Thông báo thành công khi thêm danh mục -->
                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Record inserted successfully!</strong>
                            </div>

                        </form>
                    </div>

                </div>

                <!-- Hiển thị danh sách danh mục -->
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Category name</th>
                                <th>Edit</th>
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy danh sách danh mục từ cơ sở dữ liệu
                            $res = mysqli_query($link, "SELECT * FROM categories");
                            while ($row = mysqli_fetch_array($res)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id'] ?></td>
                                    <td><?php echo $row['category_name'] ?></td>
                                    <td><center><a href="edit_categories.php?id=<?php echo $row["id"]?>" style="color:teal">Edit</a></center></td>  <!-- Edit -->
                                    <td><center><a href="delete_categories.php?id=<?php echo $row["id"]?>" style="color:red">Delete</a></center></td>  <!-- Delete -->
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
    // Kiểm tra xem danh mục đã tồn tại trong cơ sở dữ liệu chưa
    $res = mysqli_query($link, "SELECT * FROM categories WHERE category_name='$_POST[categoryname]'");
    $count = mysqli_num_rows($res);

    // Nếu danh mục đã tồn tại, hiển thị thông báo lỗi
    if ($count > 0) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "block";  // Hiển thị lỗi
            document.getElementById("success").style.display = "none"; // Ẩn thông báo thành công
        </script>
        <?php
    } else {
        // Nếu danh mục chưa tồn tại, thêm danh mục mới vào cơ sở dữ liệu
        mysqli_query($link, "INSERT INTO categories VALUES(NULL,'$_POST[categoryname]')") or die(mysqli_error($link));

        // Ghi nhận hoạt động khi thêm danh mục mới
        $category_name = $_POST['categoryname'];  // Lấy tên danh mục
        $activity = "Added new category: $category_name";  // Mô tả hoạt động
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
include("./footer.php");  // Bao gồm footer của trang web
?>
