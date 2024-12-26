<?php
session_start();
if (!isset($_SESSION["user"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}
include("./header.php");
include "../admin/conn.php";
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>
                Return Product list</a></div>
    </div>

    <div class="container-fluid">
        <form class="form-inline" action="" name="form1" method="post">
            <div class="form-group">
                <label for="email">Select Start Date</label>
                <input type="text" name="dt" id="dt" autocomplete="off" class="form-control" required
                    style="width:200px;border-style:solid; border-width:1px; border-color:#666666"
                    placeholder="click here to open calender">
            </div>
            <div class="form-group">
                <label for="email">Select End Date</label>
                <input type="text" name="dt2" id="dt2" autocomplete="off" placeholder="click here to open calender"
                    class="form-control" style="width:200px;border-style:solid; border-width:1px; border-color:#666666">
            </div>
            <button type="submit" name="submit1" class="btn btn-success">Show Purchase From These Dates</button>
            <button type="button" name="submit2" class="btn btn-warning"
                onclick="window.location.href=window.location.href">Clear Search</button>
        </form>
        <br>
        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <?php
            if (isset($_POST["submit1"])) 
            { ?>
                <table class="table table-bordered">
                    <tr>
                        <td>Bill No</td>
                        <td>Return By</td>
                        <td>Return Date</td>
                        <td>Product Company</td>
                        <td>Product Name</td>
                        <td>Product Unit</td>
                        <td>Packing Size</td>
                        <td>Product Price</td>
                        <td>Product Qty</td>
                        <td>Total</td>
                    </tr>
                    <?php
                    $res = mysqli_query($link, "SELECT * FROM return_products WHERE (return_date>='$_POST[dt]' && return_date<='$_POST[dt2]') ORDER BY id ASC") or die(mysqli_error($link));
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<tr>";
                        echo "<td>";
                        echo $row["bill_no"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["return_by"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["return_date"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_company"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_name"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_unit"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["packing_size"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_price"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_qty"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["total"];
                        echo "</td>";
                        echo "</tr>";
                    }

                    ?>
                </table>
            <?php } else { ?>
                <table class="table table-bordered">
                    <tr>
                        <td>Bill No</td>
                        <td>Return By</td>
                        <td>Return Date</td>
                        <td>Product Company</td>
                        <td>Product Name</td>
                        <td>Product Unit</td>
                        <td>Packing Size</td>
                        <td>Product Price</td>
                        <td>Product Qty</td>
                        <td>Total</td>
                    </tr>
                    <?php
                    $res = mysqli_query($link, "SELECT * FROM return_products ORDER BY id ASC");
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<tr>";
                        echo "<td>";
                        echo $row["bill_no"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["return_by"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["return_date"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_company"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_name"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_unit"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["packing_size"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_price"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["product_qty"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["total"];
                        echo "</td>";
                        echo "</tr>";
                    }

                    ?>
                </table>
            <?php } ?>

        </div>

    </div>
</div>



<?php
include("./footer.php");
?>