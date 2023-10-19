<?php
// Функция для сортировки товаров в алфавитном порядке по столбцу
function sort_table($column, $order, &$result)
{
    $stmt = $GLOBALS['db']->prepare("SELECT id, item_name FROM shopping_list WHERE user_id=? ORDER BY $column $order");
    $stmt->bind_param("i", $GLOBALS['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
}

// Функция для генерирования текстового предствления капчи
function generate_random_text($length = 6)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $text = '';
    for ($i = 0; $i < $length; $i++) {
        $text .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $text;
}
