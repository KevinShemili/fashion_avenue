<?php
session_start();
echo '<body style="background-color:#eee">';
include '../database/config.php';

if (!isset($_SESSION['admin_name'])) {
    header("location:login_form.php");
    exit;
}

if (isset($_POST['prd_id'])) {
    $productID = $_POST['prd_id'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new product</title>
    <link rel="stylesheet" href="../css/addProduct.css">
    <script src="../javascript/expand_product.js" defer></script>
</head>

<body>
    <div id="all">
        <div>
            <h3>Upload a new product</h3>
        </div>
        <div>
            <h5 id="error-msg" style="color: crimson;"></h5>
        </div>
        <div id="form-container">
            <form id="imgSubmit" method="post">
                <div id="left">
                    <div style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                        <label id="labelimg" for="image">Product Image</label><br>
                        <input id="img" type="file" name="image" accept="image/jpg, image/jpeg, image/png">
                    </div>
                    <div style="margin-top: 30px;">
                        <label for="proddesc">Product Description</label>
                        <input id="textarea" type="text" name="proddesc" placeholder="Enter description" class="input-form" required>
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
                    <div style="margin-top: 30px;">
                        <label for="qty" style="margin-right: 10px;">Quantity: </label>
                        <input id="qtyField" type="number" name="qty" placeholder="Qty" class="input-form" required style="width: 50px; height: 30px;">
                    </div>
            </form>

            <div style="margin-top: 30px;">
                <td colspan="2"><button type="button" id="btn">Update</button></td>
                <td colspan="2"><button type="button" id="btn">Add</button></td>
                <td colspan="2"><button type="button" id="btn">Remove</button></td>
            </div>

        </div>
    </div>
</body>

</html>