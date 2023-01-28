<?php
include '../database/config.php';
session_start();

if (!isset($_SESSION['client_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
} else if (isset($_SESSION['admin_name'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location:../error/error.php'));
} else if (!checkIfUserHasCC($connection) == 0 || !checkIfUserHasCC($connection) == NULL) {
    die(header('Location: ../index.php'));
}

$pattern = '/^\d{3}-\d{4}-\d{4}$/';
$errors = [];
if (isset($_POST['submit_button']) && !empty($_POST['submit_button'])) {
    try {
        $postCC = ($_POST['cc']);
        $len = strlen($_POST['cc']);
        if ($postCC && $len >= 0) {
            $creditCard = mysqli_real_escape_string($connection, $_POST['cc']);
            if (preg_match($pattern, $creditCard)) {
                $username = $_SESSION['client_name'];
                $sql_query = " UPDATE `user` SET `credit_card` = '$creditCard' WHERE `name` = '$username' ";
                $query_result = mysqli_query($connection, $sql_query);

                $sql_query2 = " INSERT INTO `cart`(`userId`) VALUES ('$username') ";
                $query_result2 = mysqli_query($connection, $sql_query2);
                header('Location: ../index.php');
            } else {
                $errors[] = "Follow the format XXX-XXXX-XXXX";
            }
        } else {
            $errors[] = "Fill all fields";
        }
    } catch (mysqli_sql_exception $e) {
        $exception = $e->getMessage();
        $errors[] = "An error occurred: $exception";
    }
}

function checkIfUserHasCC($connection)
{
    $username = $_SESSION['client_name'];
    $sql_query = " SELECT `credit_card` FROM `user` WHERE `name` = '$username' ";
    $query_result = mysqli_query($connection, $sql_query);
    $row = mysqli_fetch_assoc($query_result);
    return $row['credit_card'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Credit Card</title>
    <link rel="stylesheet" href="../css/login_register_form.css">
</head>

<body>
    <div id="container">
        <form action=" <?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <h3>Adding a credit card will provide you with the ability of making purchases.</h3>
            <?php
            if (isset($errors)) {
                foreach ($errors as $err)
                    echo '<h5 id="error-msg">' . $err . '</h5>';
            }
            ?>
            <div id="content">
                <div class="form-elements">
                    <label for="cc">Credit Card</label><br>
                    <input id="ccField" type="text" class="input-form" name="cc" placeholder="XXX-XXXX-XXXX" required>
                </div>
                <input id="buttonCC" type="submit" name="submit_button">
            </div>
        </form>

    </div>
</body>

</html>