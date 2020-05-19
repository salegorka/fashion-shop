<?php

/*
 *  Функция загружающая все заказы из бд в порядке от самого нового
 */

function readOrders($connect) {
    $sql = "select * from orders order by created_at DESC;";
    $result = mysqli_query($connect, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}