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
$res = mysqli_query($link, "SELECT * FROM books WHERE id=$id");
$row = mysqli_fetch_array($res);
$product_delete = $row["product_name"];
$user_id = $_SESSION["admin"]; 
$activity = "$user_id Deleted book with ID $id: $product_delete";
mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity')");  // Ghi hoạt động vào bảng recent_activities

mysqli_query($link, "DELETE FROM books WHERE id=$id") or die(mysqli_error($link));
?>

<script type="text/javascript">
    window.location = "add_books.php";
</script>