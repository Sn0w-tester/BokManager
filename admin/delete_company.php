<?php
include("conn.php");
$id = $_GET["id"];
mysqli_query($link, "DELETE FROM company WHERE id=$id") or die(mysqli_error($link));
?>

<script type="text/javascript">
    window.location = "add_company.php";
</script>