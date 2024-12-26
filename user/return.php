<?php
session_start();
if (!isset($_SESSION["user"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}
include "../admin/conn.php";
$id = $_GET["id"];
$bill_id = "";
$product_company = "";
$product_name = "";
$product_unit = "";
$packing_size = "";
$price = "";
$qty = "";
$total = 0;

$res = mysqli_query($link, "SELECT * FROM billing_details WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $bill_id = $row["bill_id"];
    $product_company = $row["product_company"];
    $product_name = $row["product_name"];
    $product_unit = $row["product_unit"];
    $packing_size = $row["packing_size"];
    $price = $row["price"];
    $qty = $row["qty"];
    $total = $price * $qty;
}

$bill_no = "";
$res2 = mysqli_query($link, "SELECT * FROM billing_header WHERE id=$bill_id");
while ($row2 = mysqli_fetch_array($res2)) {
    $bill_no = $row2["bill_no"];
}

$today_date = date('y-m-d');

// Insert into return_products
mysqli_query($link, "INSERT INTO return_products VALUES(NULL, '$bill_no', '$_SESSION[user]', '$today_date', '$product_company', '$product_name', '$product_unit', '$packing_size', '$price', '$qty', '$total')");

// Update stock_master to increase the quantity
mysqli_query($link, "UPDATE stock_master SET product_qty=product_qty+$qty WHERE product_company='$product_company' AND product_name='$product_name' AND product_unit='$product_unit' AND packing_size='$packing_size'");

// Delete from billing_details
mysqli_query($link, "DELETE FROM billing_details WHERE id=$id");

// Activity log
$activity_description = "Product return processed: ";
$activity_description .= "Bill No: $bill_no, ";
$activity_description .= "Product: $product_name, ";
$activity_description .= "Company: $product_company, ";
$activity_description .= "Unit: $product_unit, ";
$activity_description .= "Packing Size: $packing_size, ";
$activity_description .= "Qty: $qty, ";
$activity_description .= "Price: $price, ";
$activity_description .= "Total: $total";

// Insert activity log into recent_activities table
mysqli_query($link, "INSERT INTO recent_activities (activity_description) 
    VALUES ('$activity_description')") or die(mysqli_error($link));

?>

<script type="text/javascript">
    alert("Record taken as a return successfully");
    window.location = "view_bill_details.php?id=<?php echo $bill_id ?>";
</script>
