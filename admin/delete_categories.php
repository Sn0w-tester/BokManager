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

$res = mysqli_query($link, "SELECT * FROM categories WHERE id=$id");
$row = mysqli_fetch_array($res);
$categories_delete = $row["category_name"];

$user_id = $_SESSION["admin"]; 

$activity = "$user_id Deleted Category with ID $id: $categories_delete";

mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity')");  // Ghi hoạt động vào bảng recent_activities

mysqli_query($link, "DELETE FROM categories WHERE id=$id") or die(mysqli_error($link));
?>

<script type="text/javascript">
    window.location = "add_categories.php";
</script>