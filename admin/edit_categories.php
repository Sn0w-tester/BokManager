<?php
session_start();
if (!isset($_SESSION["admin"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}
include "conn.php";
include("./header.php");
$id = $_GET["id"];
$category = "";

$res = mysqli_query($link, "SELECT * FROM categories WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $category = $row["category_name"];
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-home"></i>
                Edit category</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Edit Categories</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                        
                            <div class="control-group">
                                <label class="control-label">Category name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Enter category" name="categoryname"
                                        value="<?php echo $category ?>" />
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Update</button>
                            </div>

                            <div class="alert alert-success" id="success" style="...">
                                <strong>Record Update successfully!</strong>
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
    // Escape dữ liệu để tránh lỗi SQL
    $new_category = mysqli_real_escape_string($link, $_POST["categoryname"]);
    $old_category = mysqli_real_escape_string($link, $category);

    // Cập nhật category trong bảng categories
    mysqli_query($link, "UPDATE categories SET category_name='$new_category' WHERE id=$id") or die(mysqli_error($link));

    // Ghi log vào bảng recent_activities
    $activity_description = mysqli_real_escape_string($link, "Category ID $id updated: '$old_category' changed to '$new_category'");
    mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity_description')") or die(mysqli_error($link));
    ?>
    <script type="text/javascript">
        document.getElementById("success").style.display = "block";
        setTimeout(function () {
            window.location = "add_categories.php";
        }, 1000);
    </script>
    <?php
}
?>

?>

<?php
include("./footer.php");
?>