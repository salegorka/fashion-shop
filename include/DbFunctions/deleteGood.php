<?php

/*
    Функция удаляющая товар из БД, категории товаров удаляются автоматически из-за настройки БД
*/
function deleteGood($connect, $id) {
    $sql = sprintf("delete from goods where id=%d;", $id);
    mysqli_query($connect, $sql);
    return 0;
}
/*

*/
function getImageToDelete($connect, $id) {
    $sql = sprintf("select image from goods where id=%d;", $id);
    $result = mysqli_query($connect, $sql);
    return array_shift(mysqli_fetch_all($result, MYSQLI_ASSOC))['image'];
}

