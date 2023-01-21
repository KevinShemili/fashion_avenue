<?php
include '../database/config.php';

echo '<body style="background-color:#eee">';
define('PASSWORD_REGEX', '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (preg_match(PASSWORD_REGEX, $password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql_query = " SELECT * FROM user WHERE email = '$email' ";
            $query_result = mysqli_query($connection, $sql_query);

            if (mysqli_num_rows($query_result) > 0) {
                $error = 'Email already exists! <a href="login_form.php" id="error-a">Log In</a>';
            } else {
                $sql_insert_query = " INSERT INTO user(name, surname, email, password, role) VALUES ('$name', '$surname','$email', '$hashed_password', 'client')";
                mysqli_query($connection, $sql_insert_query);
                header('location:login_form.php');
            }
        } else {
            $error = '<ul>
                        <li>Password must be a minimum of 8 characters</li>
                        <li>Must contain at least 1 number</li>
                        <li>Must contain at least one uppercase character</li>
                        <li>Must contain at least one lowercase character</li>
                      </ul>';
        }
    } else {
        $error = 'Please put a valid email.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" href="../css/login_register_form.css">
    <script src="../javascript/register_script.js" defer></script>
</head>

<body>
    <div id="container">
        <form action="" method="POST">
            <h3>Create your account now!</h3>
            <?php
            if (isset($error)) {
                echo '<span id="error-msg">' . $error . '</span>';
            }
            ?>
            <div id="content">
                <div class="form-elements">
                    <label for="name">Name</label><br>
                    <input type="text" class="input-form" id="nameField" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-elements">
                    <label for="surname">Surname</label><br>
                    <input type="text" class="input-form" id="surnameField" name="surname" placeholder="Enter your surname" required>
                </div>
                <div class="form-elements">
                    <label for="email">Email</label><br>
                    <input type="email" class="input-form" id="emailField" name="email" placeholder="Enter your email" required autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                </div>
                <div class="form-elements">
                    <label for="password">Password</label><br>
                    <input type="password" class="input-form" id="passField" name="password" placeholder="Enter your password" required readonly onfocus="this.removeAttribute('readonly');">
                </div>
                <input type="submit" id="button" name="submit" value="Register Now">
                <p>Already have an account? <a href="login_form.php">LogIn now</a></p>
            </div>
        </form>

    </div>

</body>

</html>