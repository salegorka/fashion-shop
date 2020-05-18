<?php

/*

    Функция возвращающая массив всех категорий на сайте

*/

function readCategories($connect) {
    $sql = "select id, name, eng_name from categories;";
    $result = mysqli_query($connect, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}