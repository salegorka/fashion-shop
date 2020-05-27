<?php 

//echo json_encode($_POST);
//echo json_encode(['error' => 'Тестовая ошибка']);

include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/createGood.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/session/sessionStart.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/session/checkAuth.php';

$maxNameSize = 255;
$fileTypes = ["image/jpeg"];
$DirImageName = $_SERVER['DOCUMENT_ROOT'] . '/img/products';

if(isset($_POST['product-name'])) {

    if ($_POST['product-name'] != strip_tags($_POST['product-name'])) {
        echo json_encode(['error' => 'Обнаружены теги в поле название товара']);
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

    } else {
        echo json_encode(['error' => "Файл не выбран"]);
        exit();
    }

    $connect = getConnect();
    $id = createGood($connect, $_POST['product-name'], $_POST['product-price'], isset($_POST['sale']) ? 1 : 0, isset($_POST['new']) ? 1 : 0);
    if (isset($_FILES['product-photo'])) {
        $tmpname = $_FILES['product-photo']['tmp_name'];
        $name = "product-" . $id . ".jpg";
        move_uploaded_file($tmpname, "$DirImageName/$name");
        saveImage($connect, $id, "/img/products/$name");
    }
    $sql = saveCategory($connect, $id, $_POST['category']);
    echo json_encode(['success' => true]);
    mysqli_close($connect);
    // echo json_encode(['success' => 'true']);
}