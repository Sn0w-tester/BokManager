<?php
session_start(); // Khởi tạo phiên làm việc (session) để quản lý đăng nhập và giỏ hàng
if (!isset($_SESSION["user"])) {
    // Nếu phiên làm việc không chứa thông tin user, điều hướng về trang đăng nhập
    ?>
    <script type="text/javascript">
        window.location = "index.php"; // Chuyển hướng tới trang đăng nhập
    </script>
    <?php
}
include "header.php"; // Bao gồm tệp header (dùng cho phần tiêu đề, menu, style, ...)
include "../admin/conn.php"; // Bao gồm tệp kết nối cơ sở dữ liệu

$bill_id = 0;
$res = mysqli_query($link, "SELECT * FROM billing_header ORDER BY id DESC LIMIT 1"); // Lấy hóa đơn gần nhất từ bảng billing_header
while ($row = mysqli_fetch_array($res)) {
    $bill_id = $row["id"]; // Lưu ID hóa đơn mới nhất
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Khởi tạo giỏ hàng nếu chưa có
    }
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bao gồm thư viện jQuery -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bao gồm FontAwesome cho icon -->

<div id="content">
    <form name="form1" action="" method="post" class="form-horizontal nopadding">
        <!-- Phần breadcrumbs: Chỉ dẫn cho người dùng -->
        <div id="content-header">
            <div id="breadcrumb"><a href="index.html" class="tip-bottom"><i class="icon-home"></i>
                    Sale a products</a></div> <!-- Đường dẫn điều hướng đến trang chủ -->
        </div>

        <div class="container-fluid">
            <div class="row-fluid" style="background-color: white; min-height: 100px; padding:10px;">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Sale a Products</h5> <!-- Tiêu đề của phần bán hàng -->
                        </div>

                        <div class="widget-content nopadding">
                            <!-- Nhập thông tin khách hàng và hóa đơn -->
                            <div class="span4">
                                <br>
                                <div>
                                    <label>Full Name</label>
                                    <input type="text" class="span12" name="full_name" required>
                                    <!-- Nhập tên khách hàng -->
                                </div>
                            </div>

                            <div class="span3">
                                <br>
                                <div>
                                    <label>Bill Type</label>
                                    <select class="span12" name="bill_type_header">
                                        <option>Cash</option>
                                        <option>Debit</option>
                                    </select> <!-- Chọn loại thanh toán (tiền mặt hoặc thẻ) -->
                                </div>
                            </div>

                            <div class="span2">
                                <br>
                                <div>
                                    <label>Date</label>
                                    <input type="text" class="span12" name="bill_date"
                                        value="<?php echo date("Y-m-d") ?>" readonly> <!-- Hiển thị ngày hiện tại -->
                                </div>
                            </div>

                            <div class="span2">
                                <br>
                                <div>
                                    <label>Bill No.</label>
                                    <input type="text" class="span12" name="bill_no"
                                        value="<?php echo generate_bill_no($bill_id); ?>" readonly>
                                    <!-- Tạo số hóa đơn tự động -->
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Phần chọn sản phẩm -->
            <div class="row-fluid" style="background-color: white; min-height: 100px; padding:10px;">
                <div class="span12">
                    <center>
                        <h4>Select A Product</h4> <!-- Tiêu đề cho phần chọn sản phẩm -->
                    </center>

                    <div class="span2">
                        <div>
                            <label>Product Company</label>
                            <select class="span11" name="company_name" id="company_name"
                                onchange="select_company(this.value)">
                                <option>Select</option>
                                <?php
                                $res = mysqli_query($link, "select * from company"); // Lấy danh sách các công ty từ cơ sở dữ liệu
                                while ($row = mysqli_fetch_array($res)) {
                                    echo "<option>";
                                    echo $row["company_name"];
                                    echo "</option>";
                                }
                                ?>
                            </select> <!-- Chọn tên công ty sản phẩm -->
                        </div>
                    </div>

                    <!-- Các trường nhập thông tin sản phẩm và tính toán giá trị -->
                    <div class="span2">
                        <div>
                            <label>Product Name</label>
                            <div id="product_name_div">
                                <select class="span11">
                                    <option>Select</option>
                                </select>
                            </div> <!-- Chọn tên sản phẩm (dựa trên công ty đã chọn) -->
                        </div>
                    </div>

                    <div class="span1">
                        <div>
                            <label>Unit</label>
                            <div id="unit_div">
                                <select class="span11">
                                    <option>Select</option>
                                </select>
                            </div> <!-- Chọn đơn vị sản phẩm -->
                        </div>
                    </div>

                    <div class="span2">
                        <div>
                            <label>Packing Size</label>
                            <div id="packing_size_div">
                                <select class="span11">
                                    <option>Select</option>
                                </select>
                            </div> <!-- Chọn kích thước đóng gói sản phẩm -->
                        </div>
                    </div>

                    <div class="span1">
                        <div>
                            <label>Price</label>
                            <input type="text" class="span11" name="price" id="price" readonly value="0">
                            <!-- Hiển thị giá sản phẩm -->
                        </div>
                    </div>

                    <div class="span1">
                        <div>
                            <label>Enter Qty</label>
                            <input type="text" class="span11" name="qty" id="qty" autocomplete="off"
                                onkeyup="generate_total(this.value)"> <!-- Nhập số lượng sản phẩm -->
                        </div>
                    </div>

                    <div class="span1">
                        <div>
                            <label>Total</label>
                            <input type="text" class="span11" name="total" id="total" value="0" readonly>
                            <!-- Tính tổng tiền -->
                        </div>
                    </div>

                    <div class="span1">
                        <div>
                            <label>&nbsp</label>
                            <input type="button" class="span11 btn btn-success" value="Add" onclick="add_session();">
                            <!-- Thêm sản phẩm vào giỏ hàng -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hiển thị các sản phẩm đã chọn -->
            <div class="row-fluid" style="background-color: white; min-height: 100px; padding:10px;">
                <div class="span12">
                    <center>
                        <h4>Taken Products</h4> <!-- Tiêu đề cho phần hiển thị sản phẩm đã chọn -->
                    </center>

                    <div id="bill_products"></div> <!-- Danh sách các sản phẩm đã chọn -->

                    <h4>
                        <div style="float: right"><span style="float:left;">Total:&#273;</span><span style="float: left"
                                id="totalbill">0</span></div> <!-- Tổng số tiền -->
                    </h4>

                    <br><br><br><br>

                    <center>
                        <input type="submit" name="submit1" value="generate bill" class="btn btn-success">
                        <!-- Nút để tạo hóa đơn -->
                    </center>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    // Hàm này được gọi khi chọn một công ty, sẽ tải danh sách sản phẩm của công ty đó
    function select_company(company_name) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Cập nhật danh sách sản phẩm vào div #product_name_div
                document.getElementById("product_name_div").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "forajax/load_product_using_company.php?company_name=" + company_name, true);
        xmlhttp.send();
    }

    // Hàm này được gọi khi chọn một sản phẩm, sẽ tải thông tin đơn vị của sản phẩm đó
    function select_product(product_name, company_name) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Cập nhật danh sách đơn vị vào div #unit_div
                document.getElementById("unit_div").innerHTML = xmlhttp.responseText;
            }
        };

        // Mã hóa các tham số để tránh sự cố với ký tự đặc biệt
        var encodedProductName = encodeURIComponent(product_name);  // Mã hóa tên sản phẩm
        var encodedCompanyName = encodeURIComponent(company_name);  // Mã hóa tên công ty

        // Truyền URL đã mã hóa vào request
        xmlhttp.open(
            "GET",
            "forajax/load_unit_using_products.php?product_name=" + encodedProductName + "&company_name=" + encodedCompanyName,
            true
        );
        xmlhttp.send();
    }

    // Hàm này được gọi khi chọn một đơn vị, sẽ tải thông tin kích thước đóng gói của đơn vị đó
    function select_unit(unit, product_name, company_name) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Cập nhật danh sách kích thước đóng gói vào div #packing_size_div
                document.getElementById("packing_size_div").innerHTML = xmlhttp.responseText;

                // Khi người dùng thay đổi kích thước đóng gói, gọi hàm load_price để tải giá
                $('#packing_size').on('change', function () {
                    load_price(document.getElementById("packing_size").value);
                });
            }
        };

        // Mã hóa các tham số để tránh sự cố với ký tự đặc biệt
        var encodedProductName = encodeURIComponent(product_name);  // Mã hóa tên sản phẩm
        var encodedCompanyName = encodeURIComponent(company_name);  // Mã hóa tên công ty
        var encodedUnit = encodeURIComponent(unit);  // Mã hóa loại hàng

        // Truyền URL đã mã hóa vào request
        xmlhttp.open(
            "GET",
            "forajax/load_packingsize_using_unit.php?unit=" + encodedUnit + "&product_name=" + encodedProductName + "&company_name=" + encodedCompanyName,
            true
        );
        xmlhttp.send();
    }

    // Hàm này được gọi để tải giá sản phẩm dựa trên kích thước đóng gói
    function load_price(packing_size) {
        var company_name = document.getElementById("company_name").value;
        var product_name = document.getElementById("product_name").value;
        var unit = document.getElementById("unit").value;

        // Kiểm tra nếu tham số cần thiết không rỗng
        if (!company_name || !product_name || !unit || !packing_size) {
            alert("Missing required parameters.");
            return;
        }

        // Tạo URL để lấy giá
        var url = "forajax/load_price.php?company_name=" + encodeURIComponent(company_name) +
            "&product_name=" + encodeURIComponent(product_name) +
            "&unit=" + encodeURIComponent(unit) +
            "&packing_size=" + encodeURIComponent(packing_size);

        // In URL ra console để kiểm tra
        console.log("Request URL: " + url);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Cập nhật giá vào ô input #price
                document.getElementById("price").value = xmlhttp.responseText;
            }
        };

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    // Hàm này tính toán tổng tiền dựa trên số lượng và giá của sản phẩm
    function generate_total(qty) {
        var price = parseFloat(document.getElementById("price").value);  // Lấy giá trị price
        var quantity = parseFloat(qty);  // Lấy giá trị qty từ tham số truyền vào

        if (!isNaN(price) && !isNaN(quantity)) {
            // Tính tổng và cập nhật vào ô input #total
            document.getElementById("total").value = price * quantity;
        } else {
            // Nếu giá trị không hợp lệ, đặt total = 0
            document.getElementById("total").value = 0;
        }
    }

    // Hàm này thêm sản phẩm vào giỏ hàng (session)
    function add_session() {
        var product_company = document.getElementById("company_name").value;
        var product_name = document.getElementById("product_name").value;
        var unit = document.getElementById("unit").value;
        var packing_size = document.getElementById("packing_size").value;
        var price = document.getElementById("price").value;
        var qty = document.getElementById("qty").value;
        var total = document.getElementById("total").value;

        // Tạo URL để thêm sản phẩm vào session
        var url =
            "forajax/save_in_session.php?company_name=" +
            encodeURIComponent(product_company) +
            "&product_name=" +
            encodeURIComponent(product_name) +
            "&unit=" +
            encodeURIComponent(unit) +
            "&packing_size=" +
            encodeURIComponent(packing_size) +
            "&price=" +
            encodeURIComponent(price) +
            "&qty=" +
            encodeURIComponent(qty) +
            "&total=" +
            encodeURIComponent(total);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Nếu thêm thành công, tải lại giỏ hàng và thông báo
                if (xmlhttp.responseText == "") {
                    load_billing_products();
                    alert("Product added successfully");
                } else {
                    load_billing_products();
                    alert(xmlhttp.responseText);
                }
            }
        };

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    // Hàm này tải danh sách sản phẩm trong giỏ hàng
    function load_billing_products() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Cập nhật giỏ hàng vào div #bill_products
                document.getElementById("bill_products").innerHTML = xmlhttp.responseText;
                load_total_bill(); // Tải tổng tiền giỏ hàng
            }
        };
        xmlhttp.open("GET", "forajax/load_billing_products.php", true);
        xmlhttp.send();
    }

    // Hàm này tải tổng số tiền của giỏ hàng
    function load_total_bill() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Cập nhật tổng tiền vào div #totalbill
                document.getElementById("totalbill").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "forajax/load_billing_amount.php", true);
        xmlhttp.send();
    }

    // Tải danh sách sản phẩm giỏ hàng khi trang được tải
    load_billing_products();

    // Hàm này được gọi khi chỉnh sửa số lượng sản phẩm trong giỏ hàng
    function edit_qty(qty1, company_name1, product_name1, unit1, packing_size1, price1) {
        var product_company = company_name1;
        var product_name = product_name1;
        var unit = unit1;
        var packing_size = packing_size1;
        var price = price1;
        var qty = qty1;
        var total = eval(price) * eval(qty);

        // Tạo URL để cập nhật thông tin sản phẩm trong session
        var url =
            "forajax/update_in_session.php?company_name=" +
            encodeURIComponent(product_company) +
            "&product_name=" +
            encodeURIComponent(product_name) +
            "&unit=" +
            encodeURIComponent(unit) +
            "&packing_size=" +
            encodeURIComponent(packing_size) +
            "&price=" +
            encodeURIComponent(price) +
            "&qty=" +
            encodeURIComponent(qty) +
            "&total=" +
            encodeURIComponent(total);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Nếu cập nhật thành công, tải lại giỏ hàng và thông báo
                if (xmlhttp.responseText == "") {
                    load_billing_products();
                    alert("Product update successfully");
                } else {
                    load_billing_products();
                    alert(xmlhttp.responseText);
                }
            }
        };

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    // Hàm này xóa sản phẩm khỏi giỏ hàng (session)
    function delete_qty(sessionid) {
        var url =
            "forajax/delete_in_session.php?sessionid=" +
            encodeURIComponent(sessionid);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Nếu xóa thành công, tải lại giỏ hàng và thông báo
                if (xmlhttp.responseText == "") {
                    load_billing_products();
                    alert("Product delete successfully");
                } else {
                    load_billing_products();
                    alert(xmlhttp.responseText);
                }
            }
        };

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
</script>




<?php

function generate_bill_no($id)
{
    // Hàm tạo số hóa đơn tự động, định dạng hóa đơn thành 5 chữ số
    if ($id == "") {
        $id1 = 0;
    } else {
        $id1 = $id;
    }
    $id1 = $id1 + 1;

    $len = strlen($id1);

    if ($len == "1") {
        $id1 = "0000" . $id1;
    }
    if ($len == "2") {
        $id1 = "000" . $id1;
    }
    if ($len == "3") {
        $id1 = "00" . $id1;
    }
    if ($len == "4") {
        $id1 = "0" . $id1;
    }

    return "BILL-" . $id1;
}

// Hàm để ghi lại hoạt động vào bảng recent_activities
function log_activity($description)
{
    global $link;
    $sql = "INSERT INTO recent_activities (activity_description) VALUES ('$description')";
    mysqli_query($link, $sql) or die(mysqli_error($link));
}

if (isset($_POST["submit1"])) {
    $lastbillno = 0;

    // Thực hiện việc thêm hóa đơn vào bảng billing_header
    mysqli_query($link, "INSERT INTO billing_header values (null,'$_POST[full_name]','$_POST[bill_type_header]','$_POST[bill_date]','$_POST[bill_no]','$_SESSION[user]')") or die(mysqli_error($link));

    // Lấy id của hóa đơn vừa tạo
    $res = mysqli_query($link, "SELECT * FROM billing_header ORDER BY id DESC LIMIT 1") or die(mysqli_error($link));
    while ($row = mysqli_fetch_array($res)) {
        $lastbillno = $row["id"];
    }

    // Ghi lại hoạt động tạo hóa đơn
    log_activity("$_SESSION[user] Created a new bill with Bill No. $_POST[bill_no]");

    // Thực hiện việc thêm các sản phẩm vào bảng billing_details và cập nhật tồn kho
    $max = is_array($_SESSION['cart']) ? sizeof($_SESSION['cart']) : 0;
    for ($i = 0; $i < $max; $i++) {
        $company_name_session = "";
        $product_name_session = "";
        $unit_session = "";
        $packing_size_session = "";
        $price_session = "";

        if (isset($_SESSION['cart'][$i])) {
            foreach ($_SESSION['cart'][$i] as $key => $val) {
                if ($key == "company_name") {
                    $company_name_session = $val;
                } else if ($key == "product_name") {
                    $product_name_session = $val;
                } else if ($key == "unit") {
                    $unit_session = $val;
                } else if ($key == "packing_size") {
                    $packing_size_session = $val;
                } else if ($key == "qty") {
                    $qty_session = $val;
                } else if ($key == "price") {
                    $price_session = $val;
                }
            }

            if ($company_name_session != "") {
                // Thêm sản phẩm vào bảng billing_details
                mysqli_query($link, "INSERT INTO billing_details VALUES(NULL,'$lastbillno','$company_name_session','$product_name_session','$unit_session','$packing_size_session','$price_session','$qty_session')") or die(mysqli_error($link));

                // Cập nhật lại tồn kho
                mysqli_query($link, "UPDATE stock_master SET product_qty=product_qty-$qty_session WHERE product_company='$company_name_session' && product_name='$product_name_session' && product_unit='$unit_session'") or die(mysqli_error($link));

                // Ghi lại hoạt động cập nhật tồn kho
                log_activity("Added $qty_session units of $product_name_session to the bill (Bill No. $lastbillno)");
            }
        }
    }

    // Xóa giỏ hàng sau khi hoàn thành việc tạo hóa đơn
    unset($_SESSION['cart']);

    // Ghi lại hoạt động xóa giỏ hàng
    log_activity("Cart cleared after bill creation.");

    ?>
    <script type="text/javascript">
        window.location.href = window.location.pathname; 
    </script>
    <?php
}




include "footer.php";
?>