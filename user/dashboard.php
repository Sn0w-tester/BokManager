<?php
session_start();
if (!isset($_SESSION["user"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
}
include "./header.php";
include "../admin/conn.php";
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>
            Dashboard</a></div>
    </div>

    <div class="container-fluid">
        <!-- Thống kê nhanh -->
        <div class="row-fluid" style="background-color: white; min-height: 200px; padding:10px;">
            <div class="card" style="width:18rem; border: 1px solid; border-radius: 10px; float:left; margin: 10px">
                <div class="card-body">
                    <a href="add_books.php">
                        <h3 class="card-title text-center">No of Books</h3>
                        <h1 class="card-text text-center">
                            <?php
                            $count = 0;
                            $res = mysqli_query($link, "SELECT * FROM books");
                            $count = mysqli_num_rows($res);
                            echo $count;
                            ?>
                        </h1>
                    </a>
                </div>
            </div>

            <div class="card" style="width:18rem; border: 1px solid; border-radius: 10px; float:left; margin: 10px">
                <div class="card-body">
                    <a href="view_bills.php">
                        <h3 class="card-title text-center">Total Orders</h3>
                        <h1 class="card-text text-center">
                            <?php
                            $count = 0;
                            $res = mysqli_query($link, "SELECT * FROM billing_header");
                            $count = mysqli_num_rows($res);
                            echo $count;
                            ?>
                        </h1>
                    </a>
                </div>
            </div>

            <div class="card" style="width:18rem; border: 1px solid; border-radius: 10px; float:left; margin: 10px">
                <div class="card-body">
                    <h3 class="card-title text-center">Low Stock Books</h3>
                    <h1 class="card-text text-center">
                        <?php
                        $count = 0;
                        $res = mysqli_query($link, "SELECT * FROM stock_master WHERE product_qty <5");
                        $count = mysqli_num_rows($res);
                        echo $count;
                        ?>
                    </h1>
                </div>
            </div>

            <div class="card" style="width:18rem; border: 1px solid; border-radius: 10px; float:left; margin: 10px">
                <div class="card-body">
                    <h3 class="card-title text-center">Total Users</h3>
                    <h1 class="card-text text-center">
                        <?php
                        $count = 0;
                        $res = mysqli_query($link, "SELECT * FROM user_registration");
                        $count = mysqli_num_rows($res);
                        echo $count;
                        ?>
                    </h1>
                </div>
            </div>

        </div>
        
        <div class="row-fluid" style="background-color: white; min-height: 200px; padding:10px;">
            <div class="card" style="width:95%; border: 1px solid; border-radius: 10px; float:left; margin: 10px">
                <div class="card-body">
                    <h3 class="card-title text-center">Total Revenue</h3>
                    <h1 class="card-text text-center">
                        <?php
                        $totalRevenue = 0;
                        $res = mysqli_query($link, "SELECT SUM(price*qty) AS revenue FROM billing_details");
                        $row = mysqli_fetch_assoc($res);
                        $totalRevenue = $row['revenue'] ?? 0;
                        echo "VNĐ " . number_format($totalRevenue, 3);
                        ?>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Danh sách hoạt động gần đây -->
        <div class="row-fluid" style="background-color: white; padding:10px; margin-top: 20px;">
            <h3>Recent Activities</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($link, "SELECT * FROM recent_activities ORDER BY activity_date DESC LIMIT 10");
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['activity_description']) . "</td>";
                        echo "<td>" . $row['activity_date'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include("./footer.php");
?>
