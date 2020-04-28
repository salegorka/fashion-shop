<?php 

/*
    Скрипт для добавления пользователя на сайт
*/

/*
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';

$email = "vasya123@mail.ru";
$password = "54321";
$fio = "Васильев Василий Васильевич";
$phone = "81112222222";

$pass_hash = password_hash($password, PASSWORD_DEFAULT);

$connect = connect();

$sql = "insert into users (email, password, fio, phone) values ('$email', '$pass_hash', '$fio', '$phone');";

$result = mysqli_query($connect, $sql);

echo "Добавление пользователя. Результат ";

var_dump($result);

echo "Ошибка " . mysqli_error($connect);

mysqli_close($connect);

*/