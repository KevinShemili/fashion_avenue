<?php

session_start();

if (!isset($_SESSION['admin_name']) && !isset($_SESSION['client_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
}


if (isset($_GET['itemPrdId'])) {
    include '../database/config.php';
    $itemPrdId = $_GET['itemPrdId'];
    $sql_query = " SELECT `productName`,`productDesc`, `brand`, `imageLocation`, `price`, `salePercentage`, `quantity`, `onSale`, `category` FROM `product` WHERE `productId` = '$itemPrdId' ";
    $query_result = mysqli_query($connection, $sql_query);

    $row = mysqli_fetch_array($query_result);

    echo json_encode($row);
}
