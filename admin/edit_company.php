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
$companyname = "";

$res = mysqli_query($link, "SELECT * FROM company WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $companyname = $row["company_name"];
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-home"></i>
                Home</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Edit Company</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Company name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Enter company name" name="companyname"
                                        value="<?php echo $companyname ?>" />
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
    $new_companyname = mysqli_real_escape_string($link, $_POST["companyname"]);
    $old_companyname = mysqli_real_escape_string($link, $companyname);

    // Cập nhật Company Name trong bảng company
    mysqli_query($link, "UPDATE company SET company_name='$new_companyname' WHERE id=$id") or die(mysqli_error($link));

    // Ghi log vào bảng recent_activities
    $activity_description = "Company ID $id updated: '$old_companyname' changed to '$new_companyname'";
    $activity_description = mysqli_real_escape_string($link, $activity_description);
    mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity_description')") or die(mysqli_error($link));

    ?>
    <script type="text/javascript">
        document.getElementById("success").style.display = "block";
        setTimeout(function () {
            window.location = "add_company.php";
        }, 1000);
    </script>
    <?php
}
?>


<?php
include("./footer.php");
?>