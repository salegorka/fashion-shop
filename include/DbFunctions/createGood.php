<?php

/*

    Функция создает товар в базе данных.

*/
function createGood($connect, $name, $price, $sale, $new) {

    mysqli_real_escape_string($connect, $name);
    $sql = sprintf("insert into goods (name, price, sale, new) values ('%s', %d, %d, %d);", mysqli_real_escape_string($connect, $name), $price
    , $sale, $new);
    mysqli_query($connect, $sql);

    $sql = sprintf("select id from goods where name='%s';", mysqli_real_escape_string($connect, $name));
    $result = mysqli_query($connect, $sql);
    $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $resultArr['0']['id'];
 
}
/*

    Функция сохраняет в бд путь к картинке с товаром.

*/
function saveImage($connect, $id, $path) {
    $sql = sprintf("update goods set image='%s' where id=%d ", $path, $id);
    mysqli_query($connect, $sql);
    return 0;
}
/*

    Функция сохраняет категории товара в таблицу категорий

*/
function saveCategory($connect, $id, $categories) {
    $sql = "insert into category_good (good_id, category_id) values";
    for($i = 0; $i < count($categories); $i++) {
        $sql = $sql . (($i != count($categories) - 1) ? sprintf(" (%d, %d), ", $id, $categories[$i]) : 
        sprintf(" (%d, %d);", $id, $categories[$i]));
    }
    $result = mysqli_query($connect, $sql);
    return $result;
}