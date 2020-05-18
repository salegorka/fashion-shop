<?php

/*
 Функция для добавления товара в бд
 */

function createOrder($connect, $orderInfo) {

    $sql = sprintf("insert into orders (fio, email, phone, delivery, address, comment, payment, json, price, status) 
values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($connect, $orderInfo['fio']),
        mysqli_real_escape_string($connect, $orderInfo['email']),
        mysqli_real_escape_string($connect, $orderInfo['phone']),
        mysqli_real_escape_string($connect, $orderInfo['delivery']),
        mysqli_real_escape_string($connect, $orderInfo['address']),
        mysqli_real_escape_string($connect, $orderInfo['comment']),
        mysqli_real_escape_string($connect, $orderInfo['payment']),
        mysqli_real_escape_string($connect, $orderInfo['json']),
        mysqli_real_escape_string($connect, $orderInfo['price']),
        mysqli_real_escape_string($connect, $orderInfo['status']));

    return mysqli_query($connect, $sql);
}