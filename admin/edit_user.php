<?php
session_start();
if (!isset($_SESSION["admin"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}

include "conn.php";
include("./header.php");
$id = $_GET["id"];
$firstname = "";
$lastname = "";
$username = "";
$password = "";
$role = "";
$status = "";

$res = mysqli_query($link, "SELECT * FROM user_registration WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $username = $row["username"];
    $password = $row["password"];
    $role = $row["role"];
    $status = $row["status"];
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-home"></i>
                Edit User</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Edit User</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="First name" name="firstname"
                                        value="<?php echo $firstname ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Last name" name="lastname"
                                        value="<?php echo $lastname ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">User Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="User name" name="username" readonly
                                        value="<?php echo $username ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password :</label>
                                <div class="controls">
                                    <input type="password" class="span11" placeholder="Enter Password" name="password"
                                        value="<?php echo $password ?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">select role :</label>
                                <div class="controls">
                                    <select name="role" class="span11">
                                        <option <?php if ($role == "user") {
                                            echo "selected";
                                        } ?>>user</option>
                                        <option <?php if ($role == "admin") {
                                            echo "selected";
                                        } ?>>admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">select status :</label>
                                <div class="controls">
                                    <select name="status" class="span11">
                                        <option <?php if ($status == "active") {
                                            echo "selected";
                                        } ?>>active</option>
                                        <option <?php if ($status == "inactive") {
                                            echo "selected";
                                        } ?>>inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Update</button>
                            </div>

                            <div class="alert alert-success" id="success" style="...">
                                <strong>Record Update successfully!</strong>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<?php
if (isset($_POST["submit1"])) {
    // Escape dữ liệu đầu vào để tránh SQL Injection
    $firstname_new = mysqli_real_escape_string($link, $_POST["firstname"]);
    $lastname_new = mysqli_real_escape_string($link, $_POST["lastname"]);
    $password_new = mysqli_real_escape_string($link, $_POST["password"]);
    $role_new = mysqli_real_escape_string($link, $_POST["role"]);
    $status_new = mysqli_real_escape_string($link, $_POST["status"]);

    // Lấy dữ liệu cũ từ database
    $res_old = mysqli_query($link, "SELECT * FROM user_registration WHERE id=$id");
    $row_old = mysqli_fetch_assoc($res_old);

    $firstname_old = $row_old["firstname"];
    $lastname_old = $row_old["lastname"];
    $password_old = $row_old["password"];
    $role_old = $row_old["role"];
    $status_old = $row_old["status"];

    // Cập nhật dữ liệu người dùng
    mysqli_query($link, "UPDATE user_registration SET 
        firstname='$firstname_new',
        lastname='$lastname_new',
        password='$password_new',
        role='$role_new',
        status='$status_new' 
        WHERE id=$id") or die(mysqli_error($link));

    // Ghi log vào bảng recent_activities
    $activity_description = "User '$username' updated: ";
    $changes = [];

    if ($firstname_old != $firstname_new) $changes[] = "First Name changed from '$firstname_old' to '$firstname_new'";
    if ($lastname_old != $lastname_new) $changes[] = "Last Name changed from '$lastname_old' to '$lastname_new'";
    if ($password_old != $password_new) $changes[] = "Password updated";
    if ($role_old != $role_new) $changes[] = "Role changed from '$role_old' to '$role_new'";
    if ($status_old != $status_new) $changes[] = "Status changed from '$status_old' to '$status_new'";

    if (!empty($changes)) {
        $activity_description .= implode(", ", $changes);
        $activity_description = mysqli_real_escape_string($link, $activity_description);
        mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity_description')") or die(mysqli_error($link));
    }

    ?>
    <script type="text/javascript">
        document.getElementById("success").style.display = "block";
        setTimeout(function () {
            window.location = "add_new_user.php";
        }, 1000);
    </script>
    <?php
}
?>


<?php
include("./footer.php");
?>