<?php
session_start();
echo '<body style="background-color:#eee">';

if (!isset($_SESSION['admin_name'])) {
    header("location:login_form.php");
    exit;
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
    <script src="../javascript/add_new_product.js" defer></script>
</head>

<body>

    <div id="form-container">
        <table>
            <thead>
                <th colspan="2">
                    <h3>Upload a new product</h3>
                </th>
            </thead>
            <tr>
                <td>
                    <div id="left">
                        <label id="labelimg" for="image">Product Image</label>
                        <input id="img" type="file" name="image" accept="image/jpg, image/jpeg, image/png">
                    </div>

                </td>
                <td>
                    <div id="right">
                        <form action="" method="post" enctype="multipart/form-data">
                            <label for="prodname">Name</label><br>
                            <input type="text" name="prodname" placeholder="Enter name" class="input-form" required>
                            <label for="proddesc">Product Description</label><br>
                            <input id="textarea" type="text" name="proddesc" placeholder="Enter description" class="input-form" required>
                            <label for="brand">Product Brand</label>
                            <input type="text" name="brand" placeholder="Enter brand" class="input-form" required>
                            <label for="category">Product Category</label><br>

                            <select name="category">
                                <option value="shoes">Shoes</option>
                                <option value="underwear">Underwear</option>
                                <option value="pants">Pants</option>
                                <option value="tshirt">T-Shirt</option>
                                <option value="jacket">Jacket</option>
                                <option value="top-hat">Top & Hat</option>
                            </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2"><button>Upload</button></td>
            </tr>
            </form>
        </table>

    </div>

</body>

</html>