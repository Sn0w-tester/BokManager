<?php
session_start();
if (!isset($_SESSION["admin"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}
include("conn.php");
$id = $_GET["id"];

$res = mysqli_query($link, "SELECT * FROM user_registration WHERE id=$id");
$row = mysqli_fetch_array($res);
$username_delete = $row["username"];

$user_id = $_SESSION["admin"]; 

$activity = "$user_id Deleted User has Username: $username_delete";

mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity')");  // Ghi hoạt động vào bảng recent_activities

mysqli_query($link, "DELETE FROM user_registration WHERE id=$id");
?>

<script type="text/javascript">
    window.location = "add_new_user.php";
</script>