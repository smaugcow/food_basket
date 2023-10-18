<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $item_id = $_GET['id'];
    
    require_once '../includes/config.php';

    // Подключение к базе данных MySQL
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($db->connect_error) {
        die("Connection error: " . $db->connect_error);
    }

    // Проверка, принадлежит ли товар текущему пользователю
    $query = "SELECT shopping_list.user_id FROM shopping_list
              JOIN users ON shopping_list.user_id = users.id
              WHERE shopping_list.id=? AND users.username=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("is", $item_id, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Удаление товара из списка покупок
        $query = "DELETE FROM shopping_list WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
    }

    $db->close();
    header("Location: ../dashboard/dashboard.php");
    exit();
}  else {
     header("Location: ../dashboard/dashboard.php");
     exit();
 }
?>
