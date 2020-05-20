<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/include/session/sessionStart.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/rights/checkUserRights.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/readGoods.php';

    $connect = getConnect();

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $count = countAllGoods($connect);
    $pageCount = ceil($count / 9);

    $products = getProductsList($connect, $currentPage);
    $productsIndexs = [];
    foreach($products as $product) {
        $productsIndexs[] = $product['id'];
    }
    $categories = getCategories($connect, $productsIndexs);
    foreach($products as $product) {
        if (empty($categories[$product['id']])) {
            $categories[$product['id']][] = 'Нет категории';
        }
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Товары</title>

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
<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <a class="page-products__button button" href="/admin/products/add">Добавить товар</a>
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
  </div>
  <ul class="page-products__list">
    <?php foreach($products as $product) : ?>
        <li class="product-item page-products__item">
        <b class="product-item__name"><?= $product['name'] ?></b>
        <span class="product-item__field"><?= $product['id'] ?></span>
        <span class="product-item__field"><?= $product['price'] . " руб." ?></span>
        <span class="product-item__field"><?= implode($categories[$product['id']], ", ") ?></span>
        <span class="product-item__field"><?= $product['new'] == 1 ? "Да" : "Нет" ?></span>
        <a href="/admin/products/add?change=<?= $product['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
        <button data-id='<?= $product['id'] ?>' class="product-item__delete"></button>
        </li>
    <?php endforeach; ?>
  </ul>
  <ul class="shop__paginator paginator">
      <?php for($i = 1; $i <= $pageCount; $i++) : ?>
        <li>
            <a class="paginator__item" <?= $i == $currentPage ? "" : "href=\"/admin/products/?page=${i}\"" ?>><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
</body>
</html>
