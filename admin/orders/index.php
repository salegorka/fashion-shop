<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/include/session/sessionStart.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/readOrders.php';

    $connect = getConnect();
    $orders = readOrders($connect);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Список заказов</title>

    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

    <meta name="theme-color" content="#393939">

    <link rel="preload" href="/fonts/opensans-400-normal.woff2" as="font">
    <link rel="preload" href="/fonts/roboto-400-normal.woff2" as="font">
    <link rel="preload" href="/fonts/roboto-700-normal.woff2" as="font">

    <link rel="icon" href="/img/favicon.png">
    <link rel="stylesheet" href="/css/style.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="/js/scripts.js" defer=""></script>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-order">
    <h1 class="h h--1">Список заказов</h1>
    <ul class="page-order__list">
        <?php foreach($orders as $order) {
            if ($order['status'] == "Не выполнено") {?>
        <li class="order-item page-order__item">
            <div class="order-item__wrapper">
                <div class="order-item__group order-item__group--id">
                    <span class="order-item__title">Номер заказа</span>
                    <span class="order-item__info order-item__info--id"><?= $order['id'] ?></span>
                </div>
                <div class="order-item__group">
                    <span class="order-item__title">Сумма заказа</span>
                    <?= $order['price'] . " руб." ?>
                </div>
                <button class="order-item__toggle"></button>
            </div>
            <div class="order-item__wrapper">
                <div class="order-item__group order-item__group--margin">
                    <span class="order-item__title">Заказчик</span>
                    <span class="order-item__info"><?= $order['fio'] ?></span>
                </div>
                <div class="order-item__group">
                    <span class="order-item__title">Номер телефона</span>
                    <span class="order-item__info"><?= $order['phone'] ?></span>
                </div>
                <div class="order-item__group">
                    <span class="order-item__title">Способ доставки</span>
                    <span class="order-item__info"><?= $order['delivery'] ?></span>
                </div>
                <div class="order-item__group">
                    <span class="order-item__title">Способ оплаты</span>
                    <span class="order-item__info"><?= $order['payment'] ?></span>
                </div>
                <div class="order-item__group order-item__group--status">
                    <span class="order-item__title">Статус заказа</span>
                    <span class="order-item__info order-item__info--no"><?= $order['status'] ?></span>
                    <button class="order-item__btn" data-id="<?= $order['id'] ?>">Изменить</button>
                </div>
            </div>
            <div class="order-item__wrapper">
                <div class="order-item__group">
                    <span class="order-item__title">Адрес доставки</span>
                    <span class="order-item__info"><?= $order['delivery'] == "Самовывоз" ? "Самовывоз" : $order['address'] ?></span>
                </div>
            </div>
            <div class="order-item__wrapper">
                <div class="order-item__group">
                    <span class="order-item__title">Комментарий к заказу</span>
                    <span class="order-item__info"><?= $order['comment'] ?></span>
                </div>
            </div>
        </li>
        <?php } } ?>
        <?php foreach($orders as $order) {
            if ($order['status'] == "Выполнено") {?>
                <li class="order-item page-order__item">
                    <div class="order-item__wrapper">
                        <div class="order-item__group order-item__group--id">
                            <span class="order-item__title">Номер заказа</span>
                            <span class="order-item__info order-item__info--id"><?= $order['id'] ?></span>
                        </div>
                        <div class="order-item__group">
                            <span class="order-item__title">Сумма заказа</span>
                            <?= $order['price'] . " руб." ?>
                        </div>
                        <button class="order-item__toggle"></button>
                    </div>
                    <div class="order-item__wrapper">
                        <div class="order-item__group order-item__group--margin">
                            <span class="order-item__title">Заказчик</span>
                            <span class="order-item__info"><?= $order['fio'] ?></span>
                        </div>
                        <div class="order-item__group">
                            <span class="order-item__title">Номер телефона</span>
                            <span class="order-item__info"><?= $order['phone'] ?></span>
                        </div>
                        <div class="order-item__group">
                            <span class="order-item__title">Способ доставки</span>
                            <span class="order-item__info"><?= $order['delivery'] ?></span>
                        </div>
                        <div class="order-item__group">
                            <span class="order-item__title">Способ оплаты</span>
                            <span class="order-item__info"><?= $order['payment'] ?></span>
                        </div>
                        <div class="order-item__group order-item__group--status">
                            <span class="order-item__title">Статус заказа</span>
                            <span class="order-item__info order-item__info--yes"><?= $order['status'] ?></span>
                            <button class="order-item__btn" data-id="<?= $order['id'] ?>">Изменить</button>
                        </div>
                    </div>
                    <div class="order-item__wrapper">
                        <div class="order-item__group">
                            <span class="order-item__title">Адрес доставки</span>
                            <span class="order-item__info"><?php $order['delivery'] == "Самовывоз" ? "Самовывоз" : $order['address'] ?></span>
                        </div>
                    </div>
                    <div class="order-item__wrapper">
                        <div class="order-item__group">
                            <span class="order-item__title">Комментарий к заказу</span>
                            <span class="order-item__info"><?= $order['comment'] ?></span>
                        </div>
                    </div>
                </li>
            <?php } } ?>
    </ul>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
</body>
</html>

