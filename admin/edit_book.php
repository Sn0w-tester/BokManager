<?php
include "./header.php";
include "conn.php";
$id = $_GET["id"];
$companyname = "";
$productname = "";
$unit = "";
$packingsize = "";

$res = mysqli_query($link, "SELECT * FROM books WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $companyname = $row["company_name"];
    $productname = $row["product_name"];
    $unit = $row["unit"];
    $packingsize = $row["packing_size"];
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-user"></i>
                Edit Book</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Edit Book</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Select Company :</label>
                                <div class="controls">
                                    <select class="span11" name="companyname">
                                        <?php
                                        $res = mysqli_query($link, "SELECT * FROM company");
                                        while ($row = mysqli_fetch_array($res)) {
                                            $selected = ($row["company_name"] == $companyname) ? "selected" : "";
                                            echo "<option value='" . $row["company_name"] . "' $selected>" . $row["company_name"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="control-group">
                                <label class="control-label">Enter Book Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Book name..." name="productname"
                                        value="<?php echo $productname ?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Select Unit :</label>
                                <div class="controls">
                                    <select class="span11" name="unit">
                                        <?php
                                        $res = mysqli_query($link, "SELECT * FROM unit");
                                        while ($row = mysqli_fetch_array($res)) {
                                            $selected = ($row["units"] == $unit) ? "selected" : "";
                                            echo "<option value='" . $row["units"] . "' $selected>" . $row["units"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Enter Packing Size :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Packing Size..." name="packingsize"
                                        value="<?php echo $packingsize ?>" />
                                </div>
                            </div>

                            <div class="alert alert-danger" id="error" style="display:none">
                                <strong>This Books Already Exist!</strong> Please try another.
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
    mysqli_query($link, "UPDATE books SET company_name='$_POST[companyname]',product_name='$_POST[productname]',unit='$_POST[unit]',packing_size='$_POST[packingsize]' WHERE id=$id") or die(mysqli_error($link));
    ?>
    <script type="text/javascript">
        document.getElementById("error").style.display = "none";
        document.getElementById("success").style.display = "block";
        setTimeout(function () {
            window.location = "add_books.php";
        }, 1000);
    </script>
    <?php
}
?>

<?php
include("./footer.php");
?>