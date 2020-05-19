<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/changeOrder.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $connect = getConnect();
    if (changeOrderStatus($connect, $_POST['id'], $_POST['newStatus'])) {
        echo json_encode((['success' => true]));
    }
}
