<?php
include "../conn.php";

// Kiểm tra sự tồn tại của tham số
if (isset($_GET['product_name']) && isset($_GET['company_name']) && isset($_GET['unit'])) {
    $product_name = $_GET['product_name'];
    $company_name = $_GET['company_name'];
    $unit = $_GET['unit'];

    $res = mysqli_query($link, "SELECT * FROM books WHERE company_name='$company_name' AND product_name='$product_name' AND unit='$unit'") or die(mysqli_error($link));
    ?>
    <select class="span11" name="packing_size" id="packing_size">
        <option>Select</option>
        <?php
        while ($row = mysqli_fetch_array($res)) {
            echo "<option>";
            echo $row["packing_size"];
            echo "</option>";
        }
        ?>
    </select>
    <?php
} else {
    echo "Missing required parameters.";
}
?>
