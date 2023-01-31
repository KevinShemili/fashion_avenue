<?php

session_start();
include '../database/config.php';

if (!isset($_SESSION['admin_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
}

if (
    isset($_POST['prodname']) && isset($_POST['proddesc']) && isset($_POST['brand']) && isset($_POST['category'])
    && isset($_POST['price']) && isset($_POST['qty'])
) {
    $prodname = $_POST['prodname'];
    $prodDesc = $_POST['proddesc'];
    $prodBrand = $_POST['brand'];
    $prodCatg = $_POST['category'];
    $prodPrice = $_POST['price'];
    $prodQty = $_POST['qty'];
    if ($_POST['hiddenSale'] !== "") {
        $onSale = 1;
        $salePercentage = $_POST['hiddenSale'];
    }
}

if (isset($_FILES['image'])) {
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
    $extensions = array("jpeg", "jpg", "png");
    if (in_array($file_ext, $extensions) === false) {
        exit;
    }
    $new_file_name = uniqid() . '.' . $file_ext;
    $file_path = '../images/serverSidePhotos/' . $new_file_name;
    move_uploaded_file($file_tmp, $file_path);

    $query = "INSERT INTO product (productName, productDesc, imageName, imageLocation, brand, category, price, onSale, salePercentage, quantity) VALUES ('$prodname', '$prodDesc', '$new_file_name', 'images/serverSidePhotos/$new_file_name', '$prodBrand', '$prodCatg', '$prodPrice', '$onSale', '$salePercentage', '$prodQty')";
    $result = mysqli_query($connection, $query);
} else {
    exit;
}
