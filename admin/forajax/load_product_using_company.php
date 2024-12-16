<?php
include "../conn.php";
$company_name=$_GET['company_name'];
error_log("company_name in load_product_using_company.php: $company_name");
$res=mysqli_query($link,"SELECT * FROM books WHERE company_name='$company_name'") or die(mysqli_error($link));
?>
<select class="span11" name="product_name" id="product_name" onchange="select_product(this.value,'<?php echo $company_name ?>')">
<option>Select</option>
<?php
while($row=mysqli_fetch_array($res))
{
    echo "<option>";
    echo $row["product_name"];
    echo "</option>";
}
echo "</select>";
?>