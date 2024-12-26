<?php
session_start();  // Bắt đầu phiên làm việc (session)

if (!isset($_SESSION["admin"])) {  // Kiểm tra nếu chưa đăng nhập là admin, chuyển hướng về trang index
    ?>
    <script type="text/javascript">
        window.location = "index.php";  // Chuyển hướng về trang index nếu chưa đăng nhập
    </script>
    <?php
}

include "./header.php";  // Bao gồm header của trang web
include "conn.php";  // Bao gồm file kết nối cơ sở dữ liệu

?>
<!-- HTML phần giao diện -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-user"></i>
                Add New Book</a></div>
    </div>

    <div class="container-fluid">
        <!-- Form thêm sách mới -->
        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add New Book</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <!-- Chọn công ty -->
                            <div class="control-group">
                                <label class="control-label">Select Company :</label>
                                <div class="controls">
                                    <select class="span11" name="companyname">
                                        <?php
                                        // Lấy danh sách công ty từ cơ sở dữ liệu
                                        $res = mysqli_query($link, "select * from company");
                                        while ($row = mysqli_fetch_array($res)) {
                                            echo "<option>";
                                            echo $row["company_name"];
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Nhập tên sách -->
                            <div class="control-group">
                                <label class="control-label">Enter Book Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Book name..." name="productname" />
                                </div>
                            </div>

                            <!-- Chọn danh mục -->
                            <div class="control-group">
                                <label class="control-label">Select Categories :</label>
                                <div class="controls">
                                    <select class="span11" name="categoryname">
                                        <?php
                                        // Lấy danh sách danh mục từ cơ sở dữ liệu
                                        $res = mysqli_query($link, "select * from categories");
                                        while ($row = mysqli_fetch_array($res)) {
                                            echo "<option>";
                                            echo $row["category_name"];
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Chọn đơn vị -->
                            <div class="control-group">
                                <label class="control-label">Select Unit :</label>
                                <div class="controls">
                                    <select class="span11" name="unit">
                                        <?php
                                        // Lấy danh sách đơn vị từ cơ sở dữ liệu
                                        $res = mysqli_query($link, "select * from unit");
                                        while ($row = mysqli_fetch_array($res)) {
                                            echo "<option>";
                                            echo $row["units"];
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Nhập kích thước đóng gói -->
                            <div class="control-group">
                                <label class="control-label">Enter Packing Size :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Packing Size..." name="packingsize" />
                                </div>
                            </div>

                            <!-- Thông báo lỗi nếu sách đã tồn tại -->
                            <div class="alert alert-danger" id="error" style="display:none">
                                <strong>This Books Already Exist!</strong> Please try another.
                            </div>

                            <!-- Nút lưu -->
                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Save</button>
                            </div>

                            <!-- Thông báo thành công -->
                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Record inserted successfully!</strong>
                            </div>

                        </form>
                    </div>

                </div>

                <!-- Hiển thị danh sách sách đã thêm -->
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Company name</th>
                                <th>Book name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Packing Size</th>
                                <th>Edit</th>
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy danh sách sách từ cơ sở dữ liệu
                            $res = mysqli_query($link, "SELECT * FROM books");
                            while ($row = mysqli_fetch_array($res)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id'] ?></td>
                                    <td><?php echo $row['company_name'] ?></td>
                                    <td><?php echo $row['product_name'] ?></td>
                                    <td><?php echo $row['category'] ?></td>
                                    <td><?php echo $row['unit'] ?></td>
                                    <td><?php echo $row['packing_size'] ?></td>
                                    <td>
                                        <center><a href="edit_book.php?id=<?php echo $row["id"] ?>"
                                                style="color:teal">Edit</a></center>
                                    </td>
                                    <td>
                                        <center><a href="delete_book.php?id=<?php echo $row["id"] ?>"
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
    // Kiểm tra nếu sách đã tồn tại trong cơ sở dữ liệu
    $res = mysqli_query($link, "SELECT * FROM books WHERE product_name='$_POST[productname]'");
    $count = mysqli_num_rows($res);

    // Nếu sách đã tồn tại, hiển thị thông báo lỗi
    if ($count > 0) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "block";  // Hiển thị lỗi
            document.getElementById("success").style.display = "none"; // Ẩn thông báo thành công
        </script>
        <?php
    } else {
        // Nếu sách chưa tồn tại, thêm sách mới vào cơ sở dữ liệu
        mysqli_query($link, "INSERT INTO books VALUES(NULL, '$_POST[companyname]', '$_POST[productname]', '$_POST[categoryname]', '$_POST[unit]', '$_POST[packingsize]')") or die(mysqli_error($link));

        // Ghi nhận hoạt động khi thêm sách mới
        $book_title = $_POST['productname'];  // Lấy tên sách
        $activity = "Added new book: $book_title";  // Mô tả hoạt động
        mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity')");  // Ghi hoạt động vào bảng recent_activities

        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "none"; // Ẩn thông báo lỗi
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
