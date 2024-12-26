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

$res = mysqli_query($link, "SELECT * FROM party_info WHERE id=$id");
$row = mysqli_fetch_array($res);
$party_delete = $row["party_name"];

$user_id = $_SESSION["admin"]; 

$activity = "$user_id Deleted Party with ID $id: $party_delete";

mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity')");  // Ghi hoạt động vào bảng recent_activities

mysqli_query($link, "DELETE FROM party_info WHERE id=$id");
?>

<script type="text/javascript">
    window.location = "add_new_party.php";
</script>