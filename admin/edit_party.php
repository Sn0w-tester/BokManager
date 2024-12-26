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
$firstname = "";
$lastname = "";
$businessname = "";
$contact = "";
$address = "";
$city = "";
$res = mysqli_query($link, "SELECT * FROM party_info WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $businessname = $row["businessname"];
    $contact = $row["contact"];
    $address = $row["address"];
    $city = $row["city"];
}

?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" class="tip-bottom"><i class="icon-user"></i>
                Edit Party</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Edit Party Info</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="First name" name="firstname"
                                        value="<?php echo $firstname ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Last name" name="lastname"
                                        value="<?php echo $lastname ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Business Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Business name" name="businessname"
                                        value="<?php echo $businessname ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Contact :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Enter contact No" name="contact"
                                        value="<?php echo $contact ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <textarea class="span11" name="address" id=""><?php echo $address ?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">City :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="City" name="city"
                                        value="<?php echo $city ?>" />
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Update</button>
                            </div>

                            <div class="alert alert-success" id="success" style="display:none">
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
    // Escape dữ liệu để an toàn với SQL
    $new_firstname = mysqli_real_escape_string($link, $_POST["firstname"]);
    $new_lastname = mysqli_real_escape_string($link, $_POST["lastname"]);
    $new_businessname = mysqli_real_escape_string($link, $_POST["businessname"]);
    $new_contact = mysqli_real_escape_string($link, $_POST["contact"]);
    $new_address = mysqli_real_escape_string($link, $_POST["address"]);
    $new_city = mysqli_real_escape_string($link, $_POST["city"]);

    // Lưu thông tin cũ để ghi log
    $old_data = "Old Info: Firstname=$firstname, Lastname=$lastname, Business=$businessname, Contact=$contact, Address=$address, City=$city";
    $new_data = "New Info: Firstname=$new_firstname, Lastname=$new_lastname, Business=$new_businessname, Contact=$new_contact, Address=$new_address, City=$new_city";

    // Cập nhật dữ liệu mới
    mysqli_query($link, "UPDATE party_info SET 
        firstname='$new_firstname',
        lastname='$new_lastname',
        businessname='$new_businessname',
        contact='$new_contact',
        address='$new_address',
        city='$new_city' 
        WHERE id=$id") or die(mysqli_error($link));

    // Ghi log thay đổi vào bảng recent_activities
    $activity_description = "Party Info ID $id updated: $old_data => $new_data";
    mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity_description')") or die(mysqli_error($link));

    ?>
    <script type="text/javascript">
        document.getElementById("success").style.display = "block";
        setTimeout(function () {
            window.location = "add_new_party.php";
        }, 1000);
    </script>
    <?php
}
?>


<?php
include("./footer.php");
?>