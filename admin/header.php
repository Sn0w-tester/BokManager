<!DOCTYPE html>
<html lang="en">

<head>
    <title>BokManager</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Import thư viện CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" /> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" /> <!-- CSS hỗ trợ responsive -->
    <link rel="stylesheet" href="css/fullcalendar.css" /> <!-- CSS cho calendar -->
    <link rel="stylesheet" href="css/matrix-style.css" /> <!-- CSS style chính cho giao diện -->
    <link rel="stylesheet" href="css/matrix-media.css" /> <!-- CSS cho media queries -->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" /> <!-- Thư viện font-awesome -->
    <link rel="stylesheet" href="css/jquery.gritter.css" /> <!-- CSS cho thông báo gritter -->
    
    <!-- Import font từ Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<body>

<!-- Header -->
<div id="header">
    <!-- Hiển thị tiêu đề ADMIN và liên kết tới dashboard.php -->
    <h2 style="color: white; position: absolute">
        <a href="dashboard.php" style="color:white; margin-left: 30px; margin-top: 40px">ADMIN</a>
    </h2>
</div>

<!-- Top Navigation -->
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <!-- Menu chào mừng Admin và cung cấp chức năng Log Out -->
        <li class="dropdown" id="profile-messages">
            <a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                <i class="icon icon-user"></i> <span class="text">Welcome Admin</span><b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <!-- Đăng xuất khỏi hệ thống -->
                <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
            </ul>
        </li>
    </ul>
</div>

<!-- Sidebar Menu -->
<div id="sidebar">
    <ul>
        <!-- Liên kết tới trang Dashboard -->
        <li class="">
            <a href="dashboard.php"><i class="icon icon-home"></i><span>Dashboard</span></a>
        </li>

        <!-- Thêm người dùng mới -->
        <li class="">
            <a href="add_new_user.php"><i class="icon icon-user"></i><span>Add New User</span></a>
        </li>

        <!-- Menu Partners -->
        <li class="submenu">
            <a href="#"><i class="icon icon-th-list"></i> <span>Partners</span></a>
            <ul>
                <li>
                    <!-- Thêm công ty mới -->
                    <a href="add_company.php"><i class="fa fa-building-o"></i><span>Add New Company</span></a>
                </li>
                <li>
                    <!-- Thêm đối tác mới -->
                    <a href="add_new_party.php"><i class="fa fa-building-o"></i><span>Add New Party</span></a>
                </li>
            </ul>
        </li>

        <!-- Menu Product -->
        <li class="submenu">
            <a href="#"><i class="icon icon-th-list"></i> <span>Product</span></a>
            <ul>
                <!-- Thêm sách, danh mục và đơn vị mới -->
                <li><a href="add_books.php">Books</a></li>
                <li><a href="add_categories.php">Categories</a></li>
                <li><a href="add_new_unit.php">Add New Unit</a></li>
            </ul>
        </li>

        <!-- Purchase Master -->
        <li class="">
            <a href="purchase_master.php"><i class="icon icon-shopping-cart"></i><span>Purchase Master</span></a>
        </li>

        <!-- Sales Master -->
        <li class="">
            <a href="sales_master.php"><i class="icon icon-money"></i><span>Sales Master</span></a>
        </li>

        <!-- Menu Reports -->
        <li class="submenu">
            <a href="#"><i class="icon icon-th-list"></i> <span>Reports</span><span class="label label-important">+</span></a>
            <ul>
                <li><a href="purchase_report.php">Purchase Report</a></li>
                <li><a href="view_bills.php">Sales Report</a></li>
                <li><a href="stock_master.php">Stock Report</a></li>
                <li><a href="return_product_list.php">Return Product Report</a></li>
                <li><a href="party_report_list.php">Party Report</a></li>
                <li><a href="expiry_report.php">Expiry Report</a></li>
            </ul>
        </li>
    </ul>
</div>

<!-- Search Section (Log Out) -->
<div id="search">
    <!-- Liên kết tới chức năng đăng xuất -->
    <a href="logout.php" style="color:white">
        <i class="icon icon-share-alt"></i><span>LogOut</span>
    </a>
</div>
