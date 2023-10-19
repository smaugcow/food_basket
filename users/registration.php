<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: ../dashboard/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/registration_style.css">
</head>

<body>
    <div class="container">
        <h2>Registration</h2>
        <form action="../users/ceate_new_user.php" method="post">
            Login<br><input type="text" name="username"><br>
            Password<br><input type="password" name="password"><br>
            Confirm password<br><input type="password" name="confirm_password"><br>
            <img src="../users/captcha.php" alt="CAPTCHA"><br>
            <input type="text" name="captcha_answer" placeholder="Enter the CAPTCHA code"><br>
            <input type="submit" value="Sign up"><br>
        </form>
    </div>
    <a href="../index.php">Come back</a>
</body>

</html>