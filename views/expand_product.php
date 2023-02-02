<?php
session_start();

echo '<body style="background-color:#eee">';
include '../database/config.php';

if (!isset($_SESSION['admin_name'])) {
    header("location:login_form.php");
    exit;
}

if (isset($_GET['prdid'])) {
    $productID = $_GET['prdid'];
    $sql_query = " SELECT * FROM product WHERE productId = '$productID' ";
    $query_result = mysqli_query($connection, $sql_query);

    $row = mysqli_fetch_assoc($query_result);
} else {
    exit;
}

$errors = [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit product</title>
    <link rel="stylesheet" href="../css/addProduct.css">
    <script src="../javascript/expand_product.js" defer></script>
</head>

<body>
    <div id="all">
        <div>
            <h3>Edit product</h3>
        </div>
        <div>
            <?php
            if (isset($errors)) {
                foreach ($errors as $err)
                    echo '<h5 id="error-msg" style="color: crimson;">' . $err . '</h5>';
            }
            ?>
        </div>
        <div id="form-container">


            <div id="left" style="align-items: center; justify-content: center;">
                <div>
                    <?php echo "<img src='../" . $row['imageLocation'] . "' style='min-width: 200px; max-width: 200px; min-height: 200px; max-height: 200px;' id='imagePreview'>"; ?>
                </div>
                <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; margin-top: 20px;">

                    <h5>Total Quantity</h5>
                    <?php echo "<h5 id='totalQuantityNumber'>" . $row['quantity'] . "</h5>"; ?>
                </div>
                <div>
                    <input id="quantityUpdateField" type="number" style="margin: 10px; width: 60px;" class="input-form">
                </div>
                <div>
                    <button id="btnAdd">Add</button>
                    <button id="btnRemove">Remove</button>
                </div>
                <div>
                    <h6 id="qtyErrorMsg" style="color: crimson;"></h6>
                </div>
                <form id="imgSubmit" method=" post">
                    <div style="margin-top: 60px; display: flex; align-content: center; justify-content: center; text-align: center; flex-direction: column;">
                        <label id="labelimg" for="image">Product Image</label><br>
                        <input id="img" type="file" style="margin-left: 120px;" name="image" accept="image/jpg, image/jpeg, image/png" required>
                        <div style="margin-top: 20px;">
                            <button id="changephotobtn" name="changephotobtn" type="submit">Preview Photo</button>
                        </div>
                </form>
            </div>
        </div>

        <div id="right">
            <div>
                <label for="prodname">Name</label><br>
                <input id="prdName" type="text" name="prodname" placeholder="Enter name" class="input-form" required>
            </div>
            <div>
                <label for="brand">Product Brand</label><br>
                <input id="prdBrand" type="text" name="brand" placeholder="Enter brand" class="input-form" required>
            </div>
            <div>
                <label for="price">Product Price</label><br>
                <input id="prodPrice" type="number" name="price" placeholder="Enter price" class="input-form" required>
            </div>
            <div style="margin-top: 30px;">
                <label for="proddesc">Product Description</label>
                <textarea id="textarea" type="text" name="proddesc" style="resize: none;" placeholder="Enter description" class="input-form" required></textarea>
            </div>
            <div>
                <label for="onsale">On Sale?</label><br>
                <input id="prodOnSale" type="checkbox" name="onsale" class="input-form">
            </div>
            <div id="hiddenDiv" style="display: none;">
                <label for="hiddenSale">Sale Percentage</label><br>
                <input id="hiddenSaleField" type="number" name="hiddenSale" placeholder="%" class="input-form" required>
            </div>
            <div>
                <label for="category">Product Category</label><br>
                <select id="catg" name="category">
                    <option value="shoes">Shoes</option>
                    <option value="underwear">Underwear</option>
                    <option value="pants">Pants</option>
                    <option value="tshirt">T-Shirt</option>
                    <option value="jacket">Jacket</option>
                    <option value="top-hat">Top & Hat</option>
                </select>

            </div>




        </div>

    </div>
    <div style="margin-top: 30px;">
        <td colspan="2"><button type="button" id="btnUpdate">Update</button></td>
        <td colspan="2"><button type="button" id="btnDelete" style="background-color: crimson;">Delete</button></td>
    </div>
</body>

</html>