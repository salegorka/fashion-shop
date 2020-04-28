<?php

/*

    Функция возвращающая товар по id

*/
function getProduct($connect, $id) {
    mysqli_real_escape_string($connect, $id);
    $sql = sprintf("select * from goods where id=%d;", $id);
    $result = mysqli_query($connect, $sql);
    $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $resultArr['0'];
}