<?php
session_start();
if (!isset($_SESSION["user"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}
include "header.php";
include "../admin/conn.php";
?>

<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-home"></i>
            Purchase Report</a></div>
    </div>
    <!--End-breadcrumbs-->
    <!--Action boxes-->
    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
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
                        class="form-control"
                        style="width:200px;border-style:solid; border-width:1px; border-color:#666666">
                </div>
                <button type="submit" name="submit1" class="btn btn-success">Show Purchase From These Dates</button>
                <button type="button" name="submit2" class="btn btn-warning"
                    onclick="window.location.href=window.location.href">Clear Search</button>
            </form>

            <br>


            <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">



                <div class="span12">

                    <div class="widget-content nopadding">
                        <?php
                        if (isset($_POST["submit1"])) {
                            ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Purchase By</th>
                                        <th>Product Company</th>
                                        <th>Product Name</th>
                                        <th>Product Unit</th>
                                        <th>Product Size</th>
                                        <th>Product Qty</th>
                                        <th>Price</th>
                                        <th>Party name</th>
                                        <th>Purchase Type</th>
                                        <th>Expiry Days</th>
                                        <th>Purchase Days</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count=0;
                                    $res=mysqli_query($link, "SELECT * FROM purchase_master WHERE (purchase_date>='$_POST[dt]' && purchase_date<='$_POST[dt2]')");
                                    while($row=mysqli_fetch_array($res))
                                    {
                                        $count=$count+1;
                                        echo "<tr>";
                                        echo "<td>"; echo $count; echo"</td>";
                                        echo "<td>"; echo $row["username"]; echo"</td>";
                                        echo "<td>"; echo $row["company_name"]; echo"</td>";
                                        echo "<td>"; echo $row["product_name"]; echo"</td>";
                                        echo "<td>"; echo $row["unit"]; echo"</td>";
                                        echo "<td>"; echo $row["packing_size"]; echo"</td>";
                                        echo "<td>"; echo $row["qty"]; echo"</td>";
                                        echo "<td>"; echo $row["price"]; echo"</td>";
                                        echo "<td>"; echo $row["party_name"]; echo"</td>";
                                        echo "<td>"; echo $row["purchase_type"]; echo"</td>";
                                        echo "<td>"; echo $row["expiry_date"]; echo"</td>";
                                        echo "<td>"; echo $row["purchase_date"]; echo"</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Purchase By</th>
                                        <th>Product Company</th>
                                        <th>Product Name</th>
                                        <th>Product Unit</th>
                                        <th>Product Size</th>
                                        <th>Product Qty</th>
                                        <th>Price</th>
                                        <th>Party name</th>
                                        <th>Purchase Type</th>
                                        <th>Expiry Days</th>
                                        <th>Purchase Days</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $count=0;
                                    $res=mysqli_query($link, "SELECT * FROM purchase_master");
                                    while($row=mysqli_fetch_array($res))
                                    {
                                        $count=$count+1;
                                        echo "<tr>";
                                        echo "<td>"; echo $count; echo"</td>";
                                        echo "<td>"; echo $row["username"]; echo"</td>";
                                        echo "<td>"; echo $row["company_name"]; echo"</td>";
                                        echo "<td>"; echo $row["product_name"]; echo"</td>";
                                        echo "<td>"; echo $row["unit"]; echo"</td>";
                                        echo "<td>"; echo $row["packing_size"]; echo"</td>";
                                        echo "<td>"; echo $row["qty"]; echo"</td>";
                                        echo "<td>"; echo $row["price"]; echo"</td>";
                                        echo "<td>"; echo $row["party_name"]; echo"</td>";
                                        echo "<td>"; echo $row["purchase_type"]; echo"</td>";
                                        echo "<td>"; echo $row["expiry_date"]; echo"</td>";
                                        echo "<td>"; echo $row["purchase_date"]; echo"</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }
                        ?>


                    </div>

                </div>
            </div>


        </div>


    </div>




    <?php
    include "footer.php";
    ?>