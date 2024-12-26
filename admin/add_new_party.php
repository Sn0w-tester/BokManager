<?php
session_start();
// Kiểm tra nếu người dùng chưa đăng nhập (admin) sẽ chuyển hướng về trang index.php
if (!isset($_SESSION["admin"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}

include "./header.php"; // Gọi header
include "conn.php"; // Kết nối cơ sở dữ liệu
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-user"></i>
                Add New Party</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add New Party</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <!-- Nhập thông tin First Name -->
                            <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="First name" name="firstname" />
                                </div>
                            </div>
                            <!-- Nhập thông tin Last Name -->
                            <div class="control-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Last name" name="lastname" />
                                </div>
                            </div>
                            <!-- Nhập thông tin Business Name -->
                            <div class="control-group">
                                <label class="control-label">Business Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Business name" name="businessname" />
                                </div>
                            </div>
                            <!-- Nhập thông tin Contact -->
                            <div class="control-group">
                                <label class="control-label">Contact :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Enter contact No" name="contact" />
                                </div>
                            </div>
                            <!-- Nhập thông tin Address -->
                            <div class="control-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <textarea class="span11" name="address" id=""></textarea>
                                </div>
                            </div>
                            <!-- Nhập thông tin City -->
                            <div class="control-group">
                                <label class="control-label">City :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="City" name="city" />
                                </div>
                            </div>

                            <!-- Nút lưu -->
                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Save</button>
                            </div>

                            <!-- Thông báo thành công khi thêm mới -->
                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Record inserted successfully!</strong>
                            </div>

                        </form>
                    </div>

                </div>

                <!-- Hiển thị danh sách các Party đã có -->
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Business name</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Edit</th>
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Lấy danh sách party_info từ cơ sở dữ liệu
                            $res = mysqli_query($link, "SELECT * FROM party_info");
                            while ($row = mysqli_fetch_array($res)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['firstname'] ?></td>
                                    <td><?php echo $row['lastname'] ?></td>
                                    <td><?php echo $row['businessname'] ?></td>
                                    <td><?php echo $row['contact'] ?></td>
                                    <td><?php echo $row['address'] ?></td>
                                    <td><?php echo $row['city'] ?></td>
                                    <td>
                                        <!-- Edit button -->
                                        <center><a href="edit_party.php?id=<?php echo $row["id"] ?>"
                                                style="color:teal">Edit</a></center>
                                    </td>
                                    <td>
                                        <!-- Delete button -->
                                        <center><a href="delete_party.php?id=<?php echo $row["id"] ?> "
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
// Xử lý khi nhấn nút "Save" để thêm party vào cơ sở dữ liệu
if (isset($_POST["submit1"])) {
    // Thực hiện câu lệnh INSERT vào bảng party_info
    mysqli_query($link, "INSERT INTO party_info VALUES(NULL,'$_POST[firstname]','$_POST[lastname]','$_POST[businessname]','$_POST[contact]','$_POST[address]','$_POST[city]')");

    $businessname_added = $_POST['businessname'];  // Lấy tên đối tác
    $activity = "Added new Business: $businessname_added";  // Mô tả hoạt động
    mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity')");  // Ghi hoạt động vào bảng recent_activities

    ?>

    <script type="text/javascript">
        // Hiển thị thông báo thành công
        document.getElementById("success").style.display = "block";
        setTimeout(function () {
            // Tự động làm mới trang sau 1 giây
            window.location.href = window.location.pathname;
        }, 1000);
    </script>
    <?php
}
?>

<?php
include("./footer.php"); // Gọi footer
?>