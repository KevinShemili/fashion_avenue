<?php

session_start();

if (!isset($_SESSION['admin_name']) && !isset($_SESSION['client_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
}


if (isset($_POST['cartItemId'])) {
    include '../database/config.php';
    $cartItemId = $_POST['cartItemId'];
    $sql_query = " DELETE FROM `cartItems` WHERE `cartItemsId` = '$cartItemId' ";
    $query_result = mysqli_query($connection, $sql_query);
}
