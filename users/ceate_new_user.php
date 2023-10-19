<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: ../dashboard/dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $captcha_answer = $_POST['captcha_answer'];

    // Проверка наличия хотя бы одной цифры в пароле
    if (!preg_match('/\d/', $password)) {
        echo '<script>alert("The password must contain at least one number."); window.location = "../users/registration.php";</script>';
    } elseif ($password !== $confirm_password) {
        echo '<script>alert("Password mismatch. Please re-enter your password."); window.location = "../users/registration.php";</script>';
    } else {

        require_once '../includes/config.php';

        // Подключение к базе данных MySQL
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($db->connect_error) {
            die("Connection error: " . $db->connect_error);
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Проверка, существует ли пользователь с таким логином
        $query = "SELECT * FROM users WHERE username=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Проверка CAPTCHA на пустоту
        if (isset($_SESSION['captcha_text'])) {
            $correct_answer = $_SESSION['captcha_text'];

            // Проверка соответствия CAPTCHA
            if (strcasecmp($captcha_answer, $correct_answer) !== 0) {
                echo '<script>alert("Invalid answer to CAPTCHA. Please try again."); window.location = "../index.php";</script>';
            } else {
                // Проверка существования пользователя
                if ($result->num_rows > 0) {
                    echo '<script>alert("A user with this login already exists."); window.location = "../users/registration.php";</script>';
                } else {
                    // Регистрация нового пользователя
                    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param("ss", $username, $hashed_password);
                    $stmt->execute();
                    echo "Registration successful. <a href='../index.php' style='text-decoration: none; color: #007BFF; display: block; margin-top: 20px;'>Sign in</a>";
                }
            }
        } else {
            echo '<script>alert("Captcha error"); window.location = "../users/ceate_new_user.php";</script>';
        }

        $db->close();
    }
}
