<?php

/*

    Функция для получения списка товаров из БД. Возвращает список товаров для одной страницы на сайте.

*/
function getProductsList($connect, $page = 1) {
    $limitLeft = ($page - 1) * 9;
    $limitRight = $limitLeft + 9;
    $sql = sprintf("select id, name, price, sale, new, image from goods limit %d, %d", $limitLeft, $limitRight);
    $result = mysqli_query($connect, $sql);
    $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $resultArr;
}

/*

    Функция возвращающая массив категорий товаров, принимает массив индексов товаров.

*/
function getCategories($connect, $indexs) {

    $sql = "select good_id, name from category_good 
	            inner join categories on category_id = categories.id
                    where";              
    $searchCondition = "";
    foreach($indexs as $key => $index) {

        if ($key != (count($indexs) - 1)) {
            $searchCondition = $searchCondition . " good_id = " . $index . " OR";
        } else {
            $searchCondition = $searchCondition . " good_id = " . $index . ";";
        }
        
    }
    $sql = $sql . $searchCondition;

    $result = mysqli_query($connect, $sql);
    $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $categoriesArr = [];
    foreach($resultArr as $row) {
        if (!isset($categoriesArr[$row['good_id']])) {
            $categoriesArr[$row['good_id']] = [$row['name']];
        } else {
            array_push($categoriesArr[$row['good_id']], $row['name']);
        } 
    }

    return $categoriesArr;
}