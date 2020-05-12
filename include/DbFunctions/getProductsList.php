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

/* 



*/
function readGoods($connect, $page, $category = 0, $price_d = 0, $price_u = 40000, $sale = 0, $new = 0, $order_by='', $sort='ASC') {
    
    $sql = null;

    if ($category == 0) {
        $sql = "select * from goods where";
    } else {
        $sql = sprintf("select * from goods inner join category_good on good_id=goods.id where category_id = %d &&", mysqli_real_escape_string($connect, $category));
    }

    $sql = $sql . sprintf(" price > %d && price < %d", mysqli_real_escape_string($connect, $price_d), mysqli_real_escape_string($connect, $price_u));

    $sql = $sql . ($sale === 0 ? "" : " && sale = 1");
    $sql = $sql . ($new === 0 ? "" : " && new = 1");

    $sql = $sql . ($order_by === '' ? "" : sprintf(" order by %s %s", mysqli_real_escape_string($connect, $order_by), mysqli_real_escape_string($connect, $sort)));

    $DownLimit = ($page - 1) * 9;
    $UpLimit = $page * 9;

    $sql = $sql . sprintf(" limit %d, %d;", $DownLimit, $UpLimit);

    $result = mysqli_query($connect, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}

/*



*/
// function getAllGoodsWithCategory($connect, $page, $category = 0, $price_d = 0, $price_u = 40000, $sale = 0, $new = 0, $order_by='', $sort='ASC') {
    
// }