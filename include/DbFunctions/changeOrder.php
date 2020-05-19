<?php

/*
 * Функция, которая изменяет статус заказа в бд
 */

function changeOrderStatus($connect, $id, $newStatus) {
    $sql = sprintf("update orders set status = '%s' where id=%d", mysqli_real_escape_string($connect, $newStatus), $id);
    return mysqli_query($connect, $sql);
}