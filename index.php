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
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/index_style.css">
</head>

<body>
    <div class="container">
        <h2>Welcome</h2>
        <form action="../users/login.php" method="post">
            Login <br><input type="text" name="username"><br>
            Password <br><input type="password" name="password"><br>
            <input type="submit" value="Sign in">
        </form>
    </div>
    <a href="../users/registration.php">Sign up</a>
</body>

</html>