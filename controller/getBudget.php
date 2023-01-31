<?php

session_start();

if (!isset($_SESSION['admin_name']) && !isset($_SESSION['client_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
}

include '../database/config.php';
$sql_query = " SELECT `revenue`, `date` FROM `budget` ";
$query_result = mysqli_query($connection, $sql_query);
$prodArray = [];
while ($row = $query_result->fetch_assoc()) {
    $prodArray[] = $row;
}

echo json_encode($prodArray);
