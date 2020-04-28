<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/session/sessionStart.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/session/checkAuth.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/createGood.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/updateGood.php';

$maxNameSize = 255;
$fileTypes = ["image/jpeg"];
$DirImageName = $_SERVER['DOCUMENT_ROOT'] . '/img/products';

if(isset($_POST['product-name'])) {

    if ($_POST['product-name'] != strip_tags($_POST['product-name'])) {
        echo json_encode(['error' => 'Обнаружены тэги в поле название товара']);
        exit();
    }

    if (strlen($_POST['product-name']) >= $maxNameSize) {
        echo json_encode(['error' => 'Слишком длинное название товара.']);
        exit();
    }

    if (!is_numeric($_POST['product-price'])) {
        echo json_encode(['error' => 'В поле стоимость товара не число.']);
        exit();
    }

    if (!empty($_FILES['product-photo']['name'])) {

        if($_FILES['product-photo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => "Ошибка загрузки файла. "]);
            exit();
        }

        if(!in_array($_FILES['product-photo']['type'], $fileTypes)) {
            echo json_encode(['error' => "Недопустимый тип файла. Разрешены только картинки."]);
            exit();
        }

        //добавить удаление старой картинки

        $connect = getConnect();
        $tmpname = $_FILES['product-photo']['tmp_name'];
        $name = "product-" . $_POST['id'] . ".jpg";
        move_uploaded_file($tmpname, "$DirImageName/$name");
        saveImage($connect, $_POST['id'], "/img/products/$name");
        mysqli_close($connect);

    } 

    $connect = getConnect();
    updateGood($connect, $_POST['id'], ['name' => $_POST['product-name'], 'price' => $_POST['product-price'],
    'sale' => (isset($_POST['sale']) ? 1 : 0 ), 'new' => (isset($_POST['new']) ? 1 : 0) ]);
    updateCategories($connect, $_POST['id'], $_POST['category']);
    echo json_encode(['success' => 'true']);
    mysqli_close($connect);
}