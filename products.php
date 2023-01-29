<?php
session_start();

include 'database/config.php';

if (isset($_SESSION['admin_name'])) {
   header("location:views/admin_panel.php?pag=1");
   exit;
}
$prodArray = [];
$sql_query = " SELECT `productId`, `productName`, `productDesc`, `imageName`, `imageLocation`, `brand`, `category`, `price`, `onSale`, `salePercentage`, `quantity` FROM `product` ";
$query_result = mysqli_query($connection, $sql_query);

while ($row = $query_result->fetch_assoc()) {
   $prodArray[] = $row;
}

if (isset($_SESSION['client_name'])) {
   $userId = $_SESSION['client_name'];
   $sql_query2 = " SELECT `cartId` FROM `cart` WHERE `userId` = '$userId' ";
   $query_result2 = mysqli_query($connection, $sql_query2);
   $entry = mysqli_fetch_assoc($query_result2);
   if ($entry != null)
      $cartId = $entry['cartId'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <title>Fashion Avenue</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/responsive.css">
   <link rel="icon" href="images/fevicon.png" type="image/gif" />
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <script src="javascript/products.js" defer></script>
</head>

<body class="main-layout footer_to90 project_page">
   <header>
      <div class="header">
         <div class="header_top d_none1">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-md-4">
                     <ul class="social_icon">
                        <li> <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i>
                           </a>
                        </li>
                        <li> <a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li> <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i>
                           </a>
                        </li>
                     </ul>
                     <div class="text-center">
                        <?php
                        if (isset($_SESSION['client_name'])) {
                           echo '<p class="h5 mt-3 font-weight-bold">Welcome, ' . $_SESSION['client_name'] . '</p>';
                        }
                        ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="header_midil">
            <div class="container">
               <div class="row d_flex">
                  <div class="col-md-4">
                     <ul class="conta_icon d_none1">
                        <li><a href="#"><img src="images/email.png" alt="#" /> avenuestore@gmail.com</a> </li>
                     </ul>
                  </div>
                  <div class="col-md-4">
                     <a class="logo" href="#"><img src="images/sitelogo/imgonline-com-ua-resize-3VsgGALCBFE0eR.jpg" alt="#" /></a>
                  </div>
                  <div class="col-md-4">
                     <?php
                     if (isset($_SESSION['client_name'])) {
                        $name = $_SESSION['client_name'];
                        $sql_query = "SELECT credit_card FROM user WHERE name = '$name' ";
                        $query_result = mysqli_query($connection, $sql_query);
                        $row = mysqli_fetch_array($query_result);
                        if ($row['credit_card'] == NULL || $row['credit_card'] == 0) {
                           echo '<ul class="right_icon d_none1">
                        <a href="views/add_credit_card.php" id="shopnow-header" class="order">Enter Credit Card</a>
                     </ul>';
                        } else {
                           echo "<ul class='right_icon' style='background-color: white;'>
                                    <a href='views/cart.php?cartId=" . $cartId . "' id='shopnow-header' class='order'>
                                       <img style='min-width: 20px; max-width: 20px; min-height: 20px; max-height: 20px;' src='images/shoppingcart.png' alt='#' />
                                    </a>
                                 </ul>";
                        }
                     } else {
                        echo '<ul class="right_icon d_none1">
                        <a href="views/login_form.php" id="shopnow-header" class="order">Shop Now</a>
                     </ul>';
                     }
                     ?>

                  </div>
               </div>
            </div>
         </div>
         <div class="header_bottom">
            <div class="container">
               <div class="row">
                  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                           <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item">
                                 <a class="nav-link" href="index.php">Home</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="about.php">About</a>
                              </li>
                              <li class="nav-item active">
                                 <a class="nav-link" href="products.php">Products</a>
                              </li>
                              <?php
                              if (isset($_SESSION['client_name'])) {
                                 echo '<li class="nav-item"><a class="nav-link" href="controller/logout.php">Log Out</a></li>';
                              } else {
                                 echo '<li class="nav-item"><a class="nav-link" href="views/login_form.php">Log In</a></li>';
                                 echo '<li class="nav-item"><a class="nav-link" href="views/register_form.php">Register</a></li>';
                              }
                              ?>

                           </ul>
                        </div>
                     </nav>
                  </div>
                  <div>
                     <div class="search" style="display: flex; align-items: center; justify-content: center; flex-direction: row;">
                        <input id="searchField" class="form_sea" type="text" placeholder="Search" name="search" style="margin-right: 30px;">
                        <button id="clearBtn" style="color: white; background-color: transparent;">CLEAR</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </header>
   <div class="blue_bg" style="background-color: #f2c119;">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="titlepage">
                  <label style="color: white; font-size: 30px;" for="category">Product Category</label><br>
                  <select id="catg" name="category" style="background-color: transparent; text-align: center; width: 250px; height: 50px; border: none; color: white;">
                     <option style="color: black;" value="shoes">Shoes</option>
                     <option style="color: black;" value="underwear">Underwear</option>
                     <option style="color: black;" value="pants">Pants</option>
                     <option style="color: black;" value="tshirt">T-Shirt</option>
                     <option style="color: black;" value="jacket">Jacket</option>
                     <option style="color: black;" value="top-hat">Top & Hat</option>
                  </select>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="project" class="project">
      <div class="container">


         <div class="row">
            <div id="container" class="product_main">

               <?php
               foreach ($prodArray as $product) {
                  if ($product['onSale'] == 1) {
                     $newPrice = $product['price'] - (($product['salePercentage'] * $product['price']) / 100);
                     echo "<div style='display:flex; flex-direction: column; align-items:center; justify-content:center; text-align: center;' prdId='" . $product['productId'] . "' class='project_box'>
            <div class='dark_white_bg'><a href='views/expandProductClient.php?prdId=" . $product['productId'] . "'><img style='min-width: 200px; max-width: 200px; min-height: 200px; max-height: 200px;' src='" . $product['imageLocation'] . "' alt='#' /></a></div>
            <h3><a href='views/expandProductClient.php?prdId=" . $product['productId'] . "'>" . $product['productName'] . "</a></h3>
            <h4><s>" . $product['price'] . "$</s></h4>
            <h4 style='color: crimson;'>" . $newPrice . "$</h4>
         </div>";
                  } else {
                     echo "<div style='display:flex; flex-direction: column; align-items:center; justify-content:center; text-align: center;' prdId='" . $product['productId'] . "' class='project_box'>
            <div class='dark_white_bg'><a href='views/expandProductClient.php?prdId=" . $product['productId'] . "'><img style='min-width: 200px; max-width: 200px; min-height: 200px; max-height: 200px;' src='" . $product['imageLocation'] . "' alt='#' /></a></div>
            <h3><a href='views/expandProductClient.php?prdId=" . $product['productId'] . "'>" . $product['productName'] . "</a></h3>
            <h4>" . $product['price'] . "$</h4>
         </div>";
                  }
               }
               ?>

            </div>
         </div>
      </div>
   </div>

   <footer>
      <div class="footer">
         <div class="container">
         </div>
      </div>
   </footer>
</body>

</html>