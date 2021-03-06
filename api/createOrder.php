<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/helpers/cleanData.php';
include $_SERVER['DOCUMENT_ROOT'] . '/settings/deliverySettings.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/createOrder.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $orderInfo = [];
    $orderInfo['fio'] = clean($_POST['surname']) . " " . clean($_POST['name']) . (isset($_POST['thirdName']) ? " " . clean($_POST['thirdName']) : "");
    $orderInfo['email'] = clean($_POST['email']);
    $orderInfo['phone'] = clean($_POST['phone']);

    $orderInfo['price'] = clean($_POST['productPrice']);

    if ($_POST['delivery'] == "dev-no") {
        $orderInfo['delivery'] = "Самовывоз";
    } else {
        if ($_POST['delivery'] == "dev-yes") {
            $orderInfo['delivery'] = "Курьер";
            if ($orderInfo['price'] < PRICE_FREE_DEL) {
                $orderInfo['price'] += DELIVERY_PRICE;
            }
            $orderInfo['address'] = "г. " . clean($_POST['city']) . ", ул. " . clean($_POST['street']) . ", д. " . clean($_POST['home']) . ", кв. " . clean($_POST['aprt']);
        }
    }
    $orderInfo['payment'] = ($_POST['pay'] == "card" ? "Банковской картой" : "Наличными");
    $orderInfo['comment'] = clean($_POST['comment']) ?? "";
    $orderInfo['json'] = json_encode(['product' => $_POST['productName'], 'price' => $_POST['productPrice']]);
    $orderInfo['status'] = "Не выполнено";

    $connect = getConnect();
    if (createOrder($connect, $orderInfo)) {
        echo json_encode(['success' => true]);
    }

}