<?php
include '../database/config.php';
if (isset($_FILES['photoForm']) && isset($_POST['prdid'])) {
    $prodId = $_POST['prdid'];
    $file_name = $_FILES['photoForm']['name'];
    $file_tmp = $_FILES['photoForm']['tmp_name'];
    $file_ext = strtolower(end(explode('.', $_FILES['photoForm']['name'])));
    $extensions = array("jpeg", "jpg", "png");
    if (in_array($file_ext, $extensions) === false) {
        exit;
    }
    $new_file_name = uniqid() . '.' . $file_ext;
    $file_path = '../images/serverSidePhotos/' . $new_file_name;
    move_uploaded_file($file_tmp, $file_path);
    try {
        $query = " UPDATE `product` SET `imageName`='$new_file_name',`imageLocation`='images/serverSidePhotos/$new_file_name' WHERE `productId` = '$prodId' ";
        $result = mysqli_query($connection, $query);
    } catch (mysqli_sql_exception $e) {
        $exception = $e->getMessage();
    }
}

if (
    isset($_POST['prdid']) && isset($_POST['productName']) && isset($_POST['productBrand']) && isset($_POST['productPrice']) && isset($_POST['productDesc'])
    && isset($_POST['onSale']) && isset($_POST['qty']) && isset($_POST['category'])
) {
    $prodId = $_POST['prdid'];
    $productName = mysqli_real_escape_string($connection, $_POST['productName']);
    $productBrand = mysqli_real_escape_string($connection, $_POST['productBrand']);
    $productPrice = mysqli_real_escape_string($connection, $_POST['productPrice']);
    $productDesc = mysqli_real_escape_string($connection, $_POST['productDesc']);
    $onSale = mysqli_real_escape_string($connection, $_POST['onSale']);
    $salePercentage = mysqli_real_escape_string($connection, $_POST['salePercentage']);
    $qty = mysqli_real_escape_string($connection, $_POST['qty']);
    $catg = mysqli_real_escape_string($connection, $_POST['category']);


    try {
        $query = " UPDATE `product` SET `productName`='$productName',`productDesc`='$productDesc',`brand`='$productBrand',`category`='$catg',`price`='$productPrice',`onSale`='$onSale',`salePercentage`='$salePercentage',`quantity`='$qty' WHERE `productId` = '$prodId' ";
        $result = mysqli_query($connection, $query);
    } catch (mysqli_sql_exception $e) {
        $exception = $e->getMessage();
        $errors[] = "An error occurred: $exception";
    }
}
