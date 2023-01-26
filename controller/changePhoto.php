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
        header("HTTP/1.1 200 OK");
        header("Location: ../views/expand_product.php?prdid=" . $prodId);
    } catch (mysqli_sql_exception $e) {
        $exception = $e->getMessage();
        $errors[] = "An error occurred: $exception";
    }
}
