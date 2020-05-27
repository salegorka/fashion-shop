<?php

//var_dump($_POST);

include $_SERVER['DOCUMENT_ROOT'] . '/include/session/sessionStart.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/session/checkAuth.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/deleteGood.php';

$connect = getConnect();
$image = getImageToDelete($connect, $_POST['id']);
if ($image) {
    unlink($_SERVER['DOCUMENT_ROOT'] . $image);
}
deleteGood($connect, $_POST['id']);
mysqli_close($connect);
echo json_encode(['success' => true]);