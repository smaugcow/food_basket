<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $username = $_SESSION['username'];

    require_once '../includes/config.php';

    // Подключение к базе данных MySQL
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($db->connect_error) {
        die("Connection error: " . $db->connect_error);
    }

    // Получение ID пользователя
    $query = "SELECT id FROM users WHERE username=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $user_id = $row['id'];

    // Добавление товара в список покупок
    $query = "INSERT INTO shopping_list (user_id, item_name) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("is", $user_id, $item_name);
    $stmt->execute();

    $db->close();
    header("Location: ../dashboard/dashboard.php");
    exit();
}
?>
