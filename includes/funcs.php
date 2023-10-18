<?php
// Функция для сортировки товаров в алфавитном порядке по столбцу
function sort_table($column, $order, &$result)
{
    $stmt = $GLOBALS['db']->prepare("SELECT id, item_name FROM shopping_list WHERE user_id=? ORDER BY $column $order");
    $stmt->bind_param("i", $GLOBALS['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
}
