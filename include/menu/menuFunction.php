<?php

/*

    Функция возвращающая элементы меню
    
*/
function getMenuList($isLogIn) {
    if ($isLogIn) {
        return [
            ['Главная', '/'],
            ['Товары', '/admin/products'],
            ['Заказы', '/admin/orders'],
            ['Выйти', '/admin/logout']
        ];
    } else {
        return [
            ['Главная', '/'],
            ['Новинки', '/new'],
            ['Sale', '/sale'],
            ['Доставка', '/delivery']
        ];
    }
}

/*
    функция возвращающая индекс активного элемента меню

*/
function getActiveItemKey($menuList) {
    $currentUrlArray = parse_url($_SERVER['REQUEST_URI']);
    $currentUrl = $currentUrlArray['path'] . (isset($currentUrlArray['query']) ? "?" . $currentUrlArray['query'] : "");
    foreach($menuList as $key => $item) {
        if ($item[1] === $currentUrl) {
            return $key;
        }
    }
}