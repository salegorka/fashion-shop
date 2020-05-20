<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/findUser.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/rights/rights.php';

// Реализовать функционал с правами доступа

$form_error = null;

if (isset($_POST['auth'])) {
    $connect = getConnect();
    $user = findUserAuth($connect, $_POST['email']);
    if (!isset($user['error']) && password_verify($_POST['password'], $user[0]['password'])) {
        $_SESSION['isUserAuthorize'] = true;

        $userGroups = findUserGroups($connect, $_POST['email']);
        $userRight = 1;
        foreach($userGroups as $userGroup) {
            $right = $groups[$userGroup['group_id']][1];
            if ($right > $userRight) {
                $userRight = $right;
            }
        }
        $_SESSION['userRight'] = $userRight;

        $_SESSION['login'] = $user[0]['email'];
        header("Location: /");
    } else {
        $form_error = $user['error'];
    }
}
