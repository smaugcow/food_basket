<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Control Panel</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard_style.css">
</head>

<body>
    <div class="container">
        <h1>Ku, <?php echo $username; ?>!</h1>

        <h2>Shopping list</h2>

        <?php

        require_once '../includes/config.php';

        // Подключение к базе данных MySQL
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($db->connect_error) {
            die("Connection error: " . $db->connect_error);
        }

        require_once '../includes/funcs.php';

        // Получение ID пользователя
        $query = "SELECT id FROM users WHERE username=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Обработка фильтрации и сортировки
        $column = isset($_GET['column']) ? $_GET['column'] : 'id';
        $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

        if (isset($_POST['filter'])) {
            sort_table($column, $order, $result);
        } else {
            // Запрос списка покупок для текущего пользователя
            sort_table($column, $order, $result);
        }

        echo '<table>';
        echo '<tr>';
        echo '<th><a href="?column=id&order=' . ($column == 'id' && $order == 'ASC' ? 'DESC' : 'ASC') . '">ID ' . ($column == 'id' ? ($order == 'ASC' ? '▲' : '▼') : '') . '</a></th>';
        echo '<th><a href="?column=item_name&order=' . ($column == 'item_name' && $order == 'ASC' ? 'DESC' : 'ASC') . '">Name ' . ($column == 'item_name' ? ($order == 'ASC' ? '▲' : '▼') : '') . '</a></th>';
        echo '<th>Change name</th>';
        echo '<th>Delete</th>';
        echo '<th>Check mark</th>';
        echo '</tr>';

        $result->data_seek(0); // Сброс указателя результата к началу

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['item_name'] . '</td>';
            echo '<td><a class="edit-button" href="../items/edit_item.php?id=' . $row['id'] . '">Edit</a></td>';
            echo '<td><a class="delete-button" href="../items/delete_item.php?id=' . $row['id'] . '">Delete</a></td>';
            echo '<td><input type="checkbox" class="toggle-checkbox" data-id="' . $row['id'] . '"></td>';
            echo '</tr>';
        }

        echo '</table>';

        $db->close();
        ?>

        <h2>Add product</h2>
        <!-- Форма для добавления нового товара -->
        <form action="../items/add_item.php" method="post">
            Product Name: <input type="text" name="item_name">
            <input type="submit" value="Add">
        </form>
    </div>

    <a href="../users/logout.php" style="text-decoration: none; color: #007BFF; display: block; margin-top: 20px; margin-bottom: 20px;">Sign out</a>

    <script src="../assets/js/dashboard_func.js"></script>
</body>

</html>