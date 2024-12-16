<?php
include "./header.php";
include "conn.php";
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-user"></i>
                Add New User</a></div>
    </div>

    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add New User</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="First name" name="firstname" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Last name" name="lastname" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">User Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="User name" name="username" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password :</label>
                                <div class="controls">
                                    <input type="password" class="span11" placeholder="Enter Password"
                                        name="password" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">select role :</label>
                                <div class="controls">
                                    <select name="role" class="span11">
                                        <option>user</option>
                                        <option>admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="alert alert-danger" id="error" style="display:none">
                                <strong>This Username Already Exist!</strong> Please try another.
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Save</button>
                            </div>

                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Record inserted successfully!</strong>
                            </div>

                        </form>
                    </div>

                </div>

                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Username</th>
                                <th>role</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($link, "SELECT * FROM user_registration");
                            while ($row = mysqli_fetch_array($res)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['firstname'] ?></td>
                                    <td><?php echo $row['lastname'] ?></td>
                                    <td><?php echo $row['username'] ?></td>
                                    <td><?php echo $row['role'] ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td><center><a href="edit_user.php?id=<?php echo $row["id"]?>" style="color:#04D9B2">Edit</a></center></td>
                                    <td><center><a href="delete_user.php?id=<?php echo $row["id"]?> " style="color:red">Delete</a></center></td>
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

<?php
if (isset($_POST["submit1"])) {
    $count = 0;
    $res = mysqli_query($link, "SELECT * FROM user_registration WHERE username='$_POST[username]'");
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "block";
            document.getElementById("success").style.display = "none";
        </script>
        <?php
    } else {
        mysqli_query($link, "INSERT INTO user_registration VALUES(NULL,'$_POST[firstname]','$_POST[lastname]','$_POST[username]','$_POST[password]','$_POST[role]','active')");
        ?>
        <script type="text/javascript">
            document.getElementById("error").style.display = "none";
            document.getElementById("success").style.display = "block";
            setTimeout(function () {
                window.location.href = window.location.pathname;
            }, 1000);
        </script>
        <?php
    }
}
?>

<?php
include("./footer.php");
?>