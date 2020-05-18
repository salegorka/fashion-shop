<?php

/*

    Функция для подсчета количество товаров в базе по заданным критериям

*/

function countGoods($connect, $category = 0, $price_d = 0, $price_u = 40000, $sale = 0, $new = 0) {
    
    $sql = null;

    if ($category == 0) {
        $sql = "select count(*) from goods where";
    } else {
        $sql = sprintf("select count(*) from goods inner join category_good on good_id=goods.id where category_id = %d &&", mysqli_real_escape_string($connect, $category));
    }

    $sql = $sql . sprintf(" price > %d && price < %d", mysqli_real_escape_string($connect, $price_d), mysqli_real_escape_string($connect, $price_u));

    $sql = $sql . ($sale == 0 ? "" : " && sale = 1");
    $sql = $sql . ($new == 0 ? "" : " && new = 1");
    $sql = $sql .";";

    $result = mysqli_query($connect, $sql);
    $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $resultArr['0']['count(*)'];
}