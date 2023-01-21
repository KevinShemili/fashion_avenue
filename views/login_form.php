<?php
include '../database/config.php';

session_start();

// prevent user from pressing back button after having logged in. Which would send them again to login page.
if (isset($_SESSION['client_name']) || isset($_SESSION['admin_name'])) {
    header('location:../index.php');
    exit;
}

echo '<body style="background-color:#eee">';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql_query = " SELECT * FROM user WHERE email = '$email' ";
    $query_result = mysqli_query($connection, $sql_query);

    if (mysqli_num_rows($query_result) > 0) {
        $row = mysqli_fetch_array($query_result);
        $hashPassFromDB = $row['password'];
        if (password_verify($password, $hashPassFromDB)) {
            if ($row['role'] == 'client') {
                $_SESSION['client_name'] = $row['name'];
                header('location:../index.php');
            } else {
                $_SESSION['admin_name'] = $row['name'];
                header('location:admin.php');
            }
        } else {
            $error = 'Incorrect email or password.';
        }
    } else {
        $error = 'Incorrect email or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="../css/login_register_form.css">
</head>

<body>
    <div id="container">
        <form action="" method="POST">
            <h3>Log In</h3>
            <?php
            if (isset($error)) {
                echo '<span id="error-msg">' . $error . '</span>';
            }
            ?>
            <div id="content">
                <div class="form-elements">
                    <label for="email">Email</label><br>
                    <input type="email" class="input-form" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-elements">
                    <label for="password">Password</label><br>
                    <input type="password" class="input-form" name="password" placeholder="Enter your password" required>
                </div>
                <input type="submit" id="button" name="submit" value="Log In">
            </div>
        </form>

    </div>
</body>

</html>