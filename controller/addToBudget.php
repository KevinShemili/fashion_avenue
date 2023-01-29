<?php

session_start();
include '../database/config.php';

if (!isset($_SESSION['client_name']) && !isset($_SESSION['admin_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
}

if (isset($_POST['revenue'])) {
    $revenue = $_POST['revenue'];

    $query = " INSERT INTO `budget`(`revenue`) VALUES ('$revenue') ";
    $result = mysqli_query($connection, $query);
}
