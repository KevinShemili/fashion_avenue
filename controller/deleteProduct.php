<?php
include '../database/config.php';
if (isset($_POST['prdid'])) {
    $prdid = $_POST['prdid'];
    try {
        $query = " DELETE FROM `product` WHERE `productId` = '$prdid' ";
        $result = mysqli_query($connection, $query);
    } catch (mysqli_sql_exception $e) {
        $exception = $e->getMessage();
    }
}
