<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/countGoods.php';

$connect = getConnect();
$count = countGoods($connect, $_GET['category_id'], $_GET['priceLow'], $_GET['priceHigh'], $_GET['sale'], $_GET['new']);

$lastDigits = $count % 100;
$textCount = $count; 

if ( 10 <= $lastDigits && $lastDigits <= 20) {
    $textCount .= " моделей";
} elseif ($lastDigits % 10 >= 2 && $lastDigits % 10 <= 4) {
    $textCount .= " модели";
} elseif ($lastDigits % 10 == 1) {
    $textCount .= " модель";
} else {
    $textCount .= " моделей";
}


echo json_encode(['count' => $count, 'text' => $textCount]);