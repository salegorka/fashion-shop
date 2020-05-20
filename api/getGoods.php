<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/readGoods.php';

$connect = getConnect();
$products = readGoods($connect, $_GET['page'], $_GET['category_id'], $_GET['priceLow'], $_GET['priceHigh'],
$_GET['sale'], $_GET['new'], $_GET['order'], $_GET['sort']);

?>
<?php foreach($products as $product): ?>
<article class="shop__item product" tabindex="0">
    <div class="product__image">
    <img src='<?= $product['image'] ?>'' alt="product-name">
    </div>
    <p class="product__name"><?= $product['name'] ?></p>
    <span class="product__price"><?= $product['price'] . " руб."?></span>
</article>
<?php endforeach; ?>
