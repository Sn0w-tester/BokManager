<?php
include("conn.php");
$id = $_GET["id"];
mysqli_query($link, "DELETE FROM party_info WHERE id=$id");
?>

<script type="text/javascript">
    window.location = "add_new_party.php";
</script>