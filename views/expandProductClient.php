<?php
session_start();

echo '<body style="background-color:#eee">';
include '../database/config.php';

if (!isset($_SESSION['client_name'])) {
    header("location:login_form.php");
    exit;
}

if (isset($_GET['prdId'])) {
    $productID = $_GET['prdId'];
    $sql_query = " SELECT * FROM product WHERE productId = '$productID' ";
    $query_result = mysqli_query($connection, $sql_query);

    $row = mysqli_fetch_assoc($query_result);
} else {
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link rel="stylesheet" href="../css/expandProduct.css">
    <script src="../javascript/expandProductClient.js" defer></script>
</head>

<body>
    <div id="all">
        <div>
            <h3>View Product</h3>
            <?php
            if ($row['onSale'] == 1) {
                echo "<h3 style='color: crimson;'>ON SALE!</h3>";
                echo "<h4 style='color: crimson;'>" . $row['salePercentage'] . "% OFF</h3>";
            }
            ?>
        </div>
        <div>
            <?php
            if (isset($errors)) {
                foreach ($errors as $err)
                    echo '<h5 id="error-msg" style="color: crimson;">' . $err . '</h5>';
            }
            ?>
        </div>

        <div id="imageDiv">
            <?php echo "<img src='../" . $row['imageLocation'] . "' style='min-width: 200px; max-width: 200px; min-height: 200px; max-height: 200px;' id='img'>"; ?>
        </div>

        <div id="contentDiv">
            <div>
                <div>
                    <h3 style="display: inline;">Product Name: </h3>
                    <?php
                    echo "<h3 style='display: inline; color: #0057ae; margin-top:15px;'>" . $row['productName'] . "</h3>";
                    ?>
                </div>
                <div>
                    <h3 style="display: inline;">Product Brand: </h3>
                    <?php
                    echo "<h3 style='display: inline; color: #0057ae; margin-top:15px;'>" . $row['brand'] . "</h3>";
                    ?>
                </div>
                <div>
                    <h3 style="display: inline;">Product Price: </h3>
                    <?php
                    if ($row['onSale'] == 1) {
                        $newPrice = $row['price'] - (($row['salePercentage'] * $row['price']) / 100);
                        echo "<h3 style='display: inline; color:crimson;'><s>" . $newPrice . "$</s></h3>";
                    } else {
                        echo "<h3 style='display: inline;'>" . $row['price'] . "$</h3>";
                    } ?>
                </div>
            </div>
            <div>
                <div style="margin-top: 30px;">
                    <h3>Product Description: </h3>
                    <?php
                    echo "<p style='color: #0057ae; max-width:300px; text-wrap:wrap;'><i>" . $row['productDesc'] . "</i></p>";
                    ?>
                </div>
            </div>
            <div style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <div>
                    <?php
                    echo "<h5 style='display: inline;'>" . $row['quantity'] . " left</h5>";
                    ?>
                </div>
                <form action="" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                    <div style=" margin-top: 20px;">
                        <?php
                        echo "<input style='border: 1px solid black; width: 300px; background-color: #eee; text-align: center;' type='number' min='1' max='" . $row['quantity'] . "' name='qtyName' id='qtyField' placeholder='Quantity' required>";
                        ?>
                    </div>
                    <div>
                        <button id="addToCartBtn" style="margin-top: 10px;">
                            Add to cart
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>

</html>