<?php

session_start();
include '../database/config.php';

if (!isset($_SESSION['client_name']) && !isset($_SESSION['admin_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
}

if (
    isset($_POST['prdid']) && isset($_POST['qty'])
) {
    $prodId = mysqli_real_escape_string($connection, $_POST['prdid']);
    $qty = mysqli_real_escape_string($connection, $_POST['qty']);

    $userName = $_SESSION['client_name'];
    $sql_query = " SELECT `cartId` FROM `cart` WHERE `userId` = '$userName' ";
    $query_result = mysqli_query($connection, $sql_query);
    $row = mysqli_fetch_assoc($query_result);

    if ($row != null) {
        $cartId = $row['cartId'];
        $query = " INSERT INTO `cartitems`(`prdId`, `cartId`, `quantity`) VALUES ('$prodId','$cartId','$qty') ";
        $result = mysqli_query($connection, $query);
    } else {
        echo "noCard";
    }
}
