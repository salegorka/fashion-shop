<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/settings/dbSettings.php';

/* 

    Фукцнкция для подключения к бд, возвращает объект connect

*/
function getConnect() {

    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$connect) {
        exit("Ошибка подключения к базе данных.");
    }

    return $connect;

}
