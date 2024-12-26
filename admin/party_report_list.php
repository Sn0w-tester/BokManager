<?php
session_start();
if (!isset($_SESSION["admin"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}
include("./header.php");
include("./conn.php");
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>
                Select Company</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <form class="form-inline" action="" name="form1" method="post">
                <div class="form-group">
                    <label for="email">Select Company Name</label>
                    <select class="form-control" name="company_name" id="">
                        <?php 
                        $res=mysqli_query($link,"SELECT * FROM party_info");
                        while ($row=mysqli_fetch_array($res)) {
                            echo "<option>";
                            echo $row["businessname"];
                            echo "</option>";
                        }
                         ?>
                    </select>
                </div>
                
                <button type="submit" name="submit1" class="btn btn-success">Show Purchase From This Company</button>
                <button type="button" name="submit2" class="btn btn-warning"
                    onclick="window.location.href=window.location.href">Clear Search</button>
            </form>
            <br>
            <div class="widget-content nopadding">
                <?php
                if (isset($_POST["submit1"])) { ?>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Company Name</th>
                            <th>Product Name</th>
                            <th>Unit</th>
                            <th>Packing Size</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Party Name</th>
                            <th>Purchase Type</th>
                            <th>Expiry date</th>
                            <th>Purchase date</th>
                            <th>Purchase By</th>
                        <tr>
                            <?php
                            $res = mysqli_query($link, "SELECT * FROM purchase_master WHERE party_name='$_POST[company_name]'");
                            while ($row = mysqli_fetch_array($res)) {
                                echo "<tr>";
                                echo "<td>";
                                echo $row["company_name"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["product_name"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["unit"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["packing_size"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["qty"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["price"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["party_name"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["purchase_type"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["expiry_date"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["purchase_date"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["username"];
                                echo "</td>";
                            }
                            ?>
                    </table>
                <?php } ?>


            </div>
        </div>
    </div>
</div>

<?php
function get_total($bill_id, $link)
{
    $total = 0;
    $res2 = mysqli_query($link, "select * from billing_details where bill_id=$bill_id");
    while ($row2 = mysqli_fetch_array($res2)) {
        $total = $total + ($row2["price"] * $row2["qty"]);
    }

    return $total;
}
?>


<?php
include("./footer.php");
?>