<?php
session_start();
if (!isset($_SESSION["admin"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}
include "./header.php";
include "conn.php";

$id = $_GET["id"];
$companyname = "";
$productname = "";
$category = "";
$unit = "";
$packingsize = "";

// Lấy thông tin sách hiện tại để hiển thị
$res = mysqli_query($link, "SELECT * FROM books WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $companyname = $row["company_name"];
    $productname = $row["product_name"];
    $category = $row["category"];
    $unit = $row["unit"];
    $packingsize = $row["packing_size"];
}

?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-user"></i>
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
                                <label class="control-label">Select Category :</label>
                                <div class="controls">
                                    <select class="span11" name="categoryname">
                                        <?php
                                        $res = mysqli_query($link, "SELECT * FROM categories");
                                        while ($row = mysqli_fetch_array($res)) {
                                            $selected = ($row["category_name"] == $category) ? "selected" : "";
                                            echo "<option value='" . $row["category_name"] . "' $selected>" . $row["category_name"] . "</option>";
                                        }
                                        ?>
                                    </select>
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
                                <strong>This Book Already Exists!</strong> Please try another.
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
    // Cập nhật thông tin sách
    mysqli_query($link, "UPDATE books SET company_name='$_POST[companyname]', product_name='$_POST[productname]', category='$_POST[categoryname]', unit='$_POST[unit]', packing_size='$_POST[packingsize]' WHERE id=$id") or die(mysqli_error($link));

    // Escape các giá trị để tránh lỗi SQL
    $companyname = mysqli_real_escape_string($link, $_POST["companyname"]);
    $productname = mysqli_real_escape_string($link, $_POST["productname"]);
    $categoryname = mysqli_real_escape_string($link, $_POST["categoryname"]);
    $unit = mysqli_real_escape_string($link, $_POST["unit"]);
    $packingsize = mysqli_real_escape_string($link, $_POST["packingsize"]);

    // Tạo activity log và escape chuỗi mô tả
    $activity_description = mysqli_real_escape_string($link, "Book ID $id updated: Company='$companyname', Product='$productname', Category='$categoryname', Unit='$unit', Packing Size='$packingsize'");

    // Thực hiện chèn vào bảng recent_activities
    mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity_description')") or die(mysqli_error($link));
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