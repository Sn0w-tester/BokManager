<?php
session_start();
include "header.php";
include "./conn.php";
$bill_id = 0;
$res = mysqli_query($link, "SELECT * FROM billing_header ORDER BY id DESC LIMIT 1");
while ($row = mysqli_fetch_array($res)) {
    $bill_id = $row["id"];
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Initialize as an empty array if it's not set
    }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="content">
    <form name="form1" action="" method="post" class="form-horizontal nopadding">

        <!--breadcrumbs-->
        <div id="content-header">
            <div id="breadcrumb"><a href="index.html" class="tip-bottom"><i class="icon-home"></i>
                    Sale a products</a></div>
        </div>

        <div class="container-fluid">
            <div class="row-fluid" style="background-color: white; min-height: 100px; padding:10px;">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Sale a Products</h5>
                        </div>

                        <div class="widget-content nopadding">


                            <div class=" span4">
                                <br>

                                <div>
                                    <label>Full Name</label>
                                    <input type="text" class="span12" name="full_name" required>
                                </div>
                            </div>

                            <div class="span3">
                                <br>

                                <div>
                                    <label>Bill Type</label>
                                    <select class="span12" name="bill_type_header">
                                        <option>Cash</option>
                                        <option>Debit</option>
                                    </select>
                                </div>
                            </div>

                            <div class="span2">
                                <br>

                                <div>
                                    <label>Date</label>
                                    <input type="text" class="span12" name="bill_date"
                                        value="<?php echo date("Y-m-d") ?>" readonly>
                                </div>
                            </div>

                            <div class="span2">
                                <br>

                                <div>
                                    <label>Bill No.</label>
                                    <input type="text" class="span12" name="bill_no"
                                        value="<?php echo generate_bill_no($bill_id); ?>" readonly>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>

            <!-- new row-->
            <div class="row-fluid" style="background-color: white; min-height: 100px; padding:10px;">
                <div class="span12">


                    <center>
                        <h4>Select A Product</h4>
                    </center>


                    <div class="span2">
                        <div>
                            <label>Product Company</label>
                            <select class="span11" name="company_name" id="company_name"
                                onchange="select_company(this.value)">
                                <option>Select</option>
                                <?php
                                $res = mysqli_query($link, "select * from company");
                                while ($row = mysqli_fetch_array($res)) {
                                    echo "<option>";
                                    echo $row["company_name"];
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="span2">
                        <div>
                            <label>Product Name</label>
                            <div id="product_name_div">
                                <select class="span11">
                                    <option>Select</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="span1">
                        <div>
                            <label>Unit</label>
                            <div id="unit_div">
                                <select class="span11">
                                    <option>Select</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="span2">
                        <div>
                            <label>Packing Size</label>
                            <div id="packing_size_div">
                                <select class="span11">
                                    <option>Select</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="span1">
                        <div>
                            <label>Price</label>
                            <input type="text" class="span11" name="price" id="price" readonly value="0">
                        </div>
                    </div>

                    <div class="span1">
                        <div>
                            <label>Enter Qty</label>
                            <input type="text" class="span11" name="qty" id="qty" autocomplete="off"
                                onkeyup="generate_total(this.value)">
                        </div>
                    </div>



                    <div class="span1">
                        <div>
                            <label>Total</label>
                            <input type="text" class="span11" name="total" id="total" value="0" readonly>
                        </div>
                    </div>

                    <div class="span1">
                        <div>
                            <label>&nbsp</label>
                            <input type="button" class="span11 btn btn-success" value="Add" onclick="add_session();">
                        </div>
                    </div>

                </div>
            </div>

            <!-- end new row-->







            <div class="row-fluid" style="background-color: white; min-height: 100px; padding:10px;">
                <div class="span12">
                    <center>
                        <h4>Taken Products</h4>
                    </center>

                    <div id="bill_products"></div>

                    <h4>
                        <div style="float: right"><span style="float:left;">Total:&#273;</span><span style="float: left"
                                id="totalbill">0</span></div>
                    </h4>


                    <br><br><br><br>

                    <center>
                        <input type="submit" name="submit1" value="generate bill" class="btn btn-success">
                    </center>

                </div>
            </div>
        </div>
    </form>
</div>


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

    function select_unit(unit, product_name, company_name) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("packing_size_div").innerHTML = xmlhttp.responseText;

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

    function load_price(packing_size) {
        var company_name = document.getElementById("company_name").value;
        var product_name = document.getElementById("product_name").value;
        var unit = document.getElementById("unit").value;

        // Kiểm tra nếu tham số cần thiết không rỗng
        if (!company_name || !product_name || !unit || !packing_size) {
            alert("Missing required parameters.");
            return;
        }

        // Tạo URL
        var url = "forajax/load_price.php?company_name=" + encodeURIComponent(company_name) +
            "&product_name=" + encodeURIComponent(product_name) +
            "&unit=" + encodeURIComponent(unit) +
            "&packing_size=" + encodeURIComponent(packing_size);

        // In URL ra console để kiểm tra
        console.log("Request URL: " + url);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("price").value = xmlhttp.responseText;
            }
        };

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function generate_total(qty) {
        var price = parseFloat(document.getElementById("price").value);  // Lấy giá trị price
        var quantity = parseFloat(qty);  // Lấy giá trị qty từ tham số truyền vào

        if (!isNaN(price) && !isNaN(quantity)) {
            document.getElementById("total").value = price * quantity;  // Tính tổng
        } else {
            document.getElementById("total").value = 0;  // Nếu giá trị không hợp lệ, đặt total = 0
        }
    }

    function add_session() {
        var product_company = document.getElementById("company_name").value;
        var product_name = document.getElementById("product_name").value;
        var unit = document.getElementById("unit").value;
        var packing_size = document.getElementById("packing_size").value;
        var price = document.getElementById("price").value;
        var qty = document.getElementById("qty").value;
        var total = document.getElementById("total").value;

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

    function load_billing_products() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("bill_products").innerHTML = xmlhttp.responseText;
                load_total_bill();
            }
        };
        xmlhttp.open("GET", "forajax/load_billing_products.php", true);
        xmlhttp.send();
    }

    function load_total_bill() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("totalbill").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "forajax/load_billing_amount.php", true);
        xmlhttp.send();
    }

    load_billing_products();

    function edit_qty(qty1, company_name1, product_name1, unit1, packing_size1, price1) {
        var product_company = company_name1;
        var product_name = product_name1;
        var unit = unit1;
        var packing_size = packing_size1;
        var price = price1;
        var qty = qty1;
        var total = eval(price) * eval(qty);

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

    function delete_qty(sessionid) {
        var url =
            "forajax/delete_in_session.php?sessionid=" +
            encodeURIComponent(sessionid);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
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
    if ($len == "5") {
        $id1 = $id1;
    }

    return $id1;
}

if (isset($_POST["submit1"])) {
    $lastbillno = 0;
    mysqli_query($link, "INSERT INTO billing_header values (null,'$_POST[full_name]','$_POST[bill_type_header]','$_POST[bill_date]','$_POST[bill_no]')") or die(mysqli_error($link));

    $res = mysqli_query($link, "SELECT * FROM billing_header ORDER BY id DESC LIMIT 1") or die(mysqli_error($link));
    while ($row = mysqli_fetch_array($res)) {
        $lastbillno = $row["id"];
    }

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
                mysqli_query($link, "INSERT INTO billing_details VALUES(NULL,'$lastbillno','$company_name_session','$product_name_session','$unit_session','$packing_size_session','$price_session','$qty_session')") or die(mysqli_error($link));
                mysqli_query($link, "UPDATE stock_master SET product_qty=product_qty-$qty_session WHERE product_company='$company_name_session' && product_name='$product_name_session' && product_unit='$unit_session'") or die(mysqli_error($link));

            }
        }
    }
    unset($_SESSION['cart']);
    ?>
    <script type="text/javascript">
        window.location.href=window.location.pathname; 
    </script>
    <?php
}

include "footer.php";
?>