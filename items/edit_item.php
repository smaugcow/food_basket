<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
$username = $_SESSION['username'];

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

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

    // Получение текущего названия товара
    $query = "SELECT item_name FROM shopping_list WHERE id=? AND user_id=?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $item_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $current_item_name = $row['item_name'];

    // Обработка отправки формы для изменения названия товара
    if (isset($_POST['update_item'])) {
        $new_item_name = $_POST['new_item_name'];
        $query = "UPDATE shopping_list SET item_name=? WHERE id=? AND user_id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sii", $new_item_name, $item_id, $user_id);
        if ($stmt->execute()) {
            header("Location: ../dashboard/dashboard.php"); // Перенаправление на страницу панели управления после обновления
            exit();
        } else {
            echo "Error updating product name.";
        }
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Change name</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/edit_item_style.css">
</head>

<body>
    <div class="container">
        <h1>Change product name</h1>
        <form action="../items/edit_item.php?id=<?php echo $item_id; ?>" method="post">
            <div class="old-label">
                <label for="new_item_name">Current title: <?php echo $current_item_name; ?></label>
            </div>
            <div class="input-label">
                <label for="new_item_name">New name: </label>
            </div>
            <input type="text" id="new_item_name" name="new_item_name"><br>
            <input type="submit" name="update_item" value="Save">
        </form>
    </div>

    <a href="../dashboard/dashboard.php">Back to shopping list</a>

    <script src="../assets/js/edit_item_func.js"></script>
</body>

</html>