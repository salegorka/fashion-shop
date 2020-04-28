<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/findUser.php';

$form_error = null;

if (isset($_POST['auth'])) {
    $connect = getConnect();
    $user = findUserAuth($connect, $_POST['email']);
    if (!isset($user['error']) && password_verify($_POST['password'], $user[0]['password'])) {
        $_SESSION['isUserAuthorize'] = true;
        $_SESSION['login'] = $user[0]['email'];
        header("Location: /");
    } else {
        $form_error = $user['error'];
    }
}
