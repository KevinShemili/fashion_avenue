<?php

session_start();
include '../database/config.php';

if (!isset($_SESSION['client_name']) && !isset($_SESSION['admin_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
}

if (isset($_POST['id']) && isset($_POST['oldQty']) && isset($_POST['boughtQty'])) {
    $id = $_POST['id'];
    $oldQty = $_POST['oldQty'];
    $boughtQty = $_POST['boughtQty'];
    $newQty = $oldQty - $boughtQty;

    $query = " UPDATE `product` SET `quantity`= '$newQty' WHERE `productId` = '$id' ";
    $result = mysqli_query($connection, $query);
}
