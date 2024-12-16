<?php
session_start();

$qty_session = 0;
$max = 0;
$gtotal = 0;

if (isset($_SESSION['cart'])) {
    $max = sizeof($_SESSION['cart']);
}

for ($i = 0; $i < $max; $i++) {
    $price_session = 0;

    if (isset($_SESSION['cart'][$i])) {

        foreach ($_SESSION['cart'][$i] as $key => $val) {
            if ($key == "qty") {
                $qty_session = (int) $val; // Ép kiểu qty sang số nguyên
            } else if ($key == "price") {
                $price_session = (float) $val; // Ép kiểu price sang số thực
            }
        }

        // Tính tổng
        $gtotal = $gtotal + ($qty_session * $price_session);
    }
}

echo $gtotal;

?>