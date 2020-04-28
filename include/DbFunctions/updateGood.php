<?php

/*
    Функция для изменения товара
*/
function updateGood($connect, $id, $changingFields) {

    $sql = sprintf("update goods
    set name='%s', price=%d, sale=%d, new=%d
    where id=%d;", $changingFields['name'], $changingFields['price'], 
    $changingFields['sale'], $changingFields['new'], $id);
    $result = mysqli_query($connect, $sql);
    return $result;
} 

/*
    Функция для обновления списка категорий
*/
function updateCategories($connect, $id, $categories) {

    $sql = sprintf("delete from category_good where good_id = %d;", $id);
    mysqli_query($connect, $sql);

    $sql = "insert into category_good (good_id, category_id) values";
    for($i = 0; $i < count($categories); $i++) {
        $sql = $sql . (($i != count($categories) - 1) ? sprintf(" (%d, %d), ", $id, $categories[$i]) : 
        sprintf(" (%d, %d);", $id, $categories[$i]));
    }
    $result = mysqli_query($connect, $sql);
    return $result;
}