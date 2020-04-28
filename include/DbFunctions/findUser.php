<?php

/*

    Функция для поиска профиля пользователя в БД. Возвращает логин и пароль.

*/
function findUserAuth($connect, $email) {

    $sql = sprintf("select email, password from users where email='%s'", mysqli_real_escape_string($connect ,$email));

    $result = mysqli_query($connect ,$sql);

    $arr = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return empty($arr) ? ['error' => 'Неверный логин или пароль'] : $arr;

}