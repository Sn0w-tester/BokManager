<?php
include "../conn.php";

// Kiểm tra sự tồn tại của tham số
if (isset($_GET['product_name']) && isset($_GET['company_name'])) {
    $product_name = $_GET['product_name'];
    $company_name = $_GET['company_name'];

    $res = mysqli_query($link, "SELECT * FROM books WHERE company_name='$company_name' AND product_name='$product_name'") or die(mysqli_error($link));
    ?>
    <select class="span11" name="unit" id="unit" onchange="select_unit(this.value,'<?php echo $product_name; ?>','<?php echo $company_name; ?>')">
        <option>Select</option>
        <?php
        while ($row = mysqli_fetch_array($res)) {
            echo "<option>";
            echo $row["unit"];
            echo "</option>";
        }
        ?>
    </select>
    <?php
} else {
    echo "Missing required parameters.";
}
?>
