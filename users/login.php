<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: ../dashboard/dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha_answer = $_POST['captcha_answer'];

    require_once '../includes/config.php';

    // Подключение к базе данных MySQL
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($db->connect_error) {
        die("Connection error: " . $db->connect_error);
    }

    // Поиск пользователя по логину
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
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Проверка пароля
                if (password_verify($password, $row['password'])) {
                    $_SESSION['username'] = $username;
                    header("Location: ../dashboard/dashboard.php");
                    exit();
                } else {
                    echo '<script>alert("Incorrect password."); window.location = "../index.php";</script>';
                }
            } else {
                echo '<script>alert("User is not found."); window.location = "../index.php";</script>';
            }
        }
    } else {
        echo '<script>alert("Captcha error"); window.location = "../index.php";</script>';
    }

    $db->close();
}
