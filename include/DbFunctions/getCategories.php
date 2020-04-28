<?php

/*

    Функция возвращающая массив всех категорий на сайте

*/

function getAllCategories($connect) {
    $sql = "select id, name from categories;";
    $result = mysqli_query($connect, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}