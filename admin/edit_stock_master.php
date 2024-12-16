<?php
include "./header.php";
include "conn.php";
$id = $_GET["id"];
$product_company = "";
$product_name = "";
$product_unit = "";
$packing_size = "";
$product_qty = "";
$product_selling_price = "";

$res = mysqli_query($link, "SELECT * FROM stock_master WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $product_company = $row["product_company"];
    $product_name = $row["product_name"];
    $product_unit = $row["product_unit"];
    $packing_size = $row["packing_size"];
    $product_qty = $row["product_qty"];
    $product_selling_price = $row["product_selling_price"];
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-user"></i>
                Edit Stock Price</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Edit Stock Price</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Company :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Book name..." name="product_company"
                                        value="<?php echo $product_company ?>" readonly />
                                </div>
                            </div>


                            <div class="control-group">
                                <label class="control-label">Book Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Book name..." name="product_name"
                                        value="<?php echo $product_name ?>" readonly />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Unit :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="" name="product_unit"
                                        value="<?php echo $product_unit ?>" readonly />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Packing Size :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Packing Size..." name="packing_size"
                                        value="<?php echo $packing_size ?>" readonly />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Quantity :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="" name="product_qty"
                                        value="<?php echo $product_qty ?>" readonly />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Selling Price :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="..." name="product_selling_price"
                                        value="<?php echo $product_selling_price ?>" />
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Update</button>
                            </div>

                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Record Updated successfully!</strong>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php
if (isset($_POST["submit1"])) {
    mysqli_query($link, "UPDATE stock_master SET product_selling_price='$_POST[product_selling_price]' WHERE id=$id") or die(mysqli_error($link));
    ?>
    <script type="text/javascript">
        document.getElementById("success").style.display = "block";
        setTimeout(function () {
            window.location = "stock_master.php";
        }, 1000);
    </script>
    <?php
}
?>

<?php
include("./footer.php");
?>