<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("location:login_form.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Admin Panel</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="../javascript/admin_panel.js" defer></script>
</head>

<body class="main-layout footer_to90 fashion_page">
    <header>
        <div class="header">
            <div class="header_top d_none1">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="text-center">
                                <?php
                                if (isset($_SESSION['admin_name'])) {
                                    echo '<p class="h5 mt-3 font-weight-bold">Welcome, ' . $_SESSION['admin_name'] . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="header_midil">
                <div class="container">
                    <div class="row d_flex justify-content-center">
                        <div class="col-md-4">
                            <a class="logo" href="#"><img src="../images/sitelogo/imgonline-com-ua-resize-3VsgGALCBFE0eR.jpg" alt="#" /></a>
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
                                        <li class="nav-item ">
                                            <a class="nav-link active" href="admin_panel.php?pag=1">Main Panel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="admin_products_panel.php">Products</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="earning_panel.php">Earnings/Budget</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="../controller/logout.php">Log Out</a>
                                        </li>
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
    <div class="inner-content">
        <table class="table mt-3">
            <thead style="background-color: #f2c119; color: black; text-align: center;">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Credit Card</th>
                </tr>
            </thead>
            <tbody id="tableBody" style="text-align: center;">
            </tbody>
        </table>
    </div>
    <div id="paginationDiv">
        <nav aria-label="...">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <button id="back-btn"><a class="page-link">Previous</a></button>
                </li>
                <li class="page-item">
                    <button id="next-btn"><a class="page-link">Next</a></button>
                </li>
            </ul>
        </nav>
    </div>
    <div>
        <blockquote class="blockquote">
            <p class="mb-0" id="resultParagraph"></p>
        </blockquote>
    </div>
    <footer>
        <div class="footer">
            <div class="container">
            </div>
        </div>
    </footer>
</body>

</html>