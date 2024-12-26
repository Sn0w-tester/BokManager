<?php
// Bắt đầu session và kiểm tra xem người dùng đã đăng nhập với quyền user chưa
session_start();
if (!isset($_SESSION["user"])) {
    ?>
    <script type="text/javascript">
        // Nếu chưa đăng nhập, chuyển hướng đến trang login
        window.location = "index.php";
    </script>
    <?php
}
include "./header.php";  // Bao gồm header của trang
include "../admin/conn.php";  // Kết nối với cơ sở dữ liệu
?>

<div id="content">
    <!-- Hiển thị phần nội dung của trang thêm mới giao dịch mua -->
    <div id="content-header">
        <div id="breadcrumb">
            <a href="index.html" title="Go to Home" class="tip-bottom">
                <i class="icon-user"></i> Add New Purchase
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add New Purchase</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form name="form1" action="" method="post" class="form-horizontal">
                            <!-- Chọn công ty -->
                            <div class="control-group">
                                <label class="control-label">Select Company :</label>
                                <div class="controls">
                                    <select class="span11" name="company_name" id="company_name" onchange="select_company(this.value)">
                                        <option value="">Select</option>
                                        <?php
                                        // Lấy danh sách công ty từ cơ sở dữ liệu
                                        $res = mysqli_query($link, "select * from company");
                                        while ($row = mysqli_fetch_array($res)) {
                                            echo "<option>" . $row["company_name"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Chọn tên sản phẩm -->
                            <div class="control-group">
                                <label class="control-label">Select Book Name :</label>
                                <div class="controls" id="product_name_div">
                                    <select class="span11" name="product_name">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Chọn loại sản phẩm -->
                            <div class="control-group">
                                <label class="control-label">Select Unit :</label>
                                <div class="controls" id="unit_div">
                                    <select class="span11" name="unit">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Chọn kích thước đóng gói -->
                            <div class="control-group">
                                <label class="control-label">Enter Packing Size :</label>
                                <div class="controls" id="packing_size_div">
                                    <select class="span11" name="packing_size">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nhập số lượng -->
                            <div class="control-group">
                                <label class="control-label">Enter Qty :</label>
                                <div class="controls">
                                    <input type="number" name="qty" value="0" class="span11">
                                </div>
                            </div>

                            <!-- Nhập giá -->
                            <div class="control-group">
                                <label class="control-label">Enter Price :</label>
                                <div class="controls">
                                    <input type="text" name="price" value="0" class="span11">
                                </div>
                            </div>

                            <!-- Chọn tên đối tác -->
                            <div class="control-group">
                                <label class="control-label">Enter Party Name :</label>
                                <div class="controls">
                                    <select class="span11" name="party_name">
                                        <option value="">Select</option>
                                        <?php
                                        // Lấy danh sách đối tác từ cơ sở dữ liệu
                                        $res = mysqli_query($link, "SELECT * FROM party_info");
                                        while ($row = mysqli_fetch_array($res)) {
                                            echo "<option>" . $row["businessname"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Chọn loại giao dịch (Tiền mặt / Thẻ) -->
                            <div class="control-group">
                                <label class="control-label">Enter Purchase Type :</label>
                                <div class="controls">
                                    <select class="span11" name="purchase_type">
                                        <option value="Cash">Cash</option>
                                        <option value="Debit">Debit</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nhập ngày hết hạn -->
                            <div class="control-group">
                                <label class="control-label">Enter Expiry Date :</label>
                                <div class="controls">
                                    <input type="text" name="dt" id="dt" class="span11" placeholder="YYYY-MM-DD" required pattern="^\d{4}-\d{2}-\d{2}$">
                                </div>
                            </div>

                            <!-- Nút bấm để thêm giao dịch mua -->
                            <div class="form-actions">
                                <button type="submit" name="submit1" class="btn btn-success">Purchase Now</button>
                            </div>

                            <!-- Thông báo thành công -->
                            <div class="alert alert-success" id="success" style="display:none">
                                <strong>Purchase Inserted Successfully!</strong>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Các hàm JavaScript xử lý AJAX cho các lựa chọn động -->
<script type="text/javascript">
    function select_company(company_name) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("product_name_div").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "forajax/load_product_using_company.php?company_name=" + company_name, true);
        xmlhttp.send();
    }

    function select_product(product_name, company_name) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("unit_div").innerHTML = xmlhttp.responseText;
            }
        };
        var encodedProductName = encodeURIComponent(product_name);
        var encodedCompanyName = encodeURIComponent(company_name);
        xmlhttp.open("GET", "forajax/load_unit_using_products.php?product_name=" + encodedProductName + "&company_name=" + encodedCompanyName, true);
        xmlhttp.send();
    }

    function select_unit(unit, product_name, company_name) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("packing_size_div").innerHTML = xmlhttp.responseText;
            }
        };
        var encodedProductName = encodeURIComponent(product_name);
        var encodedCompanyName = encodeURIComponent(company_name);
        var encodedUnit = encodeURIComponent(unit);
        xmlhttp.open("GET", "forajax/load_packingsize_using_unit.php?unit=" + encodedUnit + "&product_name=" + encodedProductName + "&company_name=" + encodedCompanyName, true);
        xmlhttp.send();
    }
</script>

<?php
// Xử lý khi người dùng nhấn nút "Purchase Now"
if (isset($_POST["submit1"])) {
    // Thêm thông tin giao dịch vào bảng purchase_master
    $today_date = date("Y-m-d");
    mysqli_query($link, "INSERT INTO purchase_master VALUES(NULL, '$_POST[company_name]', '$_POST[product_name]', '$_POST[unit]', '$_POST[packing_size]', '$_POST[qty]', '$_POST[price]', '$_POST[party_name]', '$_POST[purchase_type]', '$_POST[dt]', '$today_date', '$_SESSION[user]')") or die(mysqli_error($link));

    // Kiểm tra xem sản phẩm đã tồn tại trong kho chưa, nếu chưa, thêm mới vào bảng stock_master
    $count = 0;
    $res = mysqli_query($link, "SELECT * FROM stock_master WHERE product_company='$_POST[company_name]' AND product_name='$_POST[product_name]' AND product_unit='$_POST[unit]' ");
    $count = mysqli_num_rows($res);

    if ($count == 0) {
        // Nếu không có, thêm sản phẩm mới vào bảng kho
        mysqli_query($link, "INSERT INTO stock_master VALUES(NULL, '$_POST[company_name]', '$_POST[product_name]', '$_POST[unit]', '$_POST[packing_size]', '$_POST[qty]', '0')") or die(mysqli_error($link));
    } else {
        // Nếu có rồi, cập nhật số lượng sản phẩm trong kho
        mysqli_query($link, "UPDATE stock_master SET product_qty=product_qty+$_POST[qty] WHERE product_company='$_POST[company_name]' AND product_name='$_POST[product_name]' AND product_unit='$_POST[unit]'") or die(mysqli_error($link));
    }

    // Ghi log hoạt động vào bảng recent_activities
    $activity_description = "Purchase made: Company: " . $_POST['company_name'] . ", Product: " . $_POST['product_name'] . ", Unit: " . $_POST['unit'] . ", Qty: " . $_POST['qty'] . ", Price: " . $_POST['price'] . ", Purchase Type: " . $_POST['purchase_type'] . ", Party: " . $_POST['party_name'] . ", Expiry Date: " . $_POST['dt'];
    mysqli_query($link, "INSERT INTO recent_activities (activity_description) VALUES ('$activity_description')") or die(mysqli_error($link));

    // Hiển thị thông báo thành công
    ?>
    <script type="text/javascript">
        document.getElementById("success").style.display = "block";
    </script>
    <?php
}
?>
