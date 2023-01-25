<?php

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
}

include '../database/config.php';
$userArray = [];
$sql_query = " SELECT `productId`, `productName`, `productDesc`, `imageName`, `imageLocation`, `brand`, `category`, `price`, `onSale`, `salePercentage`, `quantity` FROM `product` ";
$query_result = mysqli_query($connection, $sql_query);

while ($row = $query_result->fetch_assoc()) {
    $userArray[] = $row;
}

echo json_encode($userArray);
