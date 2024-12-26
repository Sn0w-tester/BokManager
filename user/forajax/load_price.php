<?php
include "../../admin/conn.php";

// Kiểm tra sự tồn tại của các tham số trước khi sử dụng
$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : null;
$company_name = isset($_GET['company_name']) ? $_GET['company_name'] : null;
$unit = isset($_GET['unit']) ? $_GET['unit'] : null;
$packing_size = isset($_GET['packing_size']) ? $_GET['packing_size'] : null;

// Kiểm tra nếu tất cả các tham số đều tồn tại
if ($product_name && $company_name && $unit && $packing_size) {
    $res = mysqli_query($link, "SELECT * FROM stock_master WHERE product_company='$company_name' AND product_name='$product_name' AND product_unit='$unit' AND packing_size='$packing_size'") or die(mysqli_error($link));

    // Kiểm tra nếu có kết quả trả về
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_array($res)) {
            echo $row["product_selling_price"]; // Trả về giá bán
        }
    } else {
        echo "No price found.";
    }
} else {
    echo "Missing required parameters.";
}
?>
