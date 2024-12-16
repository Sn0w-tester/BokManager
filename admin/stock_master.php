<?php
include "./header.php";
include "conn.php";
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-user"></i>
                Stock Master</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Stock Master</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Company </th>
                                    <th>Book </th>
                                    <th>Unit</th>
                                    <th>Packing Size</th>
                                    <th>Quantity</th>
                                    <th>Selling Price</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count=0;
                                $res = mysqli_query($link, "SELECT * FROM stock_master");
                                while ($row = mysqli_fetch_array($res)) {
                                    $count=$count+1;
                                    ?>
                                    <tr>
                                        <td><?php echo $count ?></td>
                                        <td><?php echo $row['product_company'] ?></td>
                                        <td><?php echo $row['product_name'] ?></td>
                                        <td><?php echo $row['product_unit'] ?></td>
                                        <td><?php echo $row['packing_size'] ?></td>
                                        <td><?php echo $row['product_qty'] ?></td>
                                        <td><?php echo $row['product_selling_price'] ?></td>
                                        <td>
                                            <center><a href="edit_stock_master.php?id=<?php echo $row["id"] ?>"
                                                    style="color:teal">Edit</a></center>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>


            </div>
        </div>

    </div>
</div>

<?php
include("./footer.php");
?>