<?php 
    include $_SERVER['DOCUMENT_ROOT'] . '/include/session/sessionStart.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/connectToDb.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/readCategories.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/getProduct.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/include/DbFunctions/getProductsList.php';

    $connect = getConnect();
    $categories = readCategories($connect);

    $product = null;

    if (isset($_GET['change'])) {
        $product = getProduct($connect, $_GET['change']);
        $productCategories = array_pop(getCategories($connect, [$_GET['change']]));
        if (empty($productCategories)) {
            $productCategories[] = "Нет категории";
        }
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Добавление товара</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="preload" href="/fonts/opensans-400-normal.woff2" as="font">
  <link rel="preload" href="/fonts/roboto-400-normal.woff2" as="font">
  <link rel="preload" href="/fonts/roboto-700-normal.woff2" as="font">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.min.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="/js/scripts.js" defer=""></script>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-add">
  <h1 class="h h--1"><?= isset($product) ? "Изменение товара " . $product['name'] : "Добавление товара" ?></h1>
  <form class="custom-form" name="<?= isset($product) ? "change" : "add" ?>" action="" method="post">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name" value ="<?= isset($product) ? $product['name'] : "" ?>">
        <?php if (!isset($product)) : ?>
          <p class="custom-form__input-label">
            Название товара
          </p>
        <?php endif; ?>
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price" value ="<?= isset($product) ? $product['price'] : "" ?>">
        <?php if (!isset($product)) : ?>
          <p class="custom-form__input-label">
            Цена товара
          </p>
        <?php endif; ?>
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <ul class="add-list">
        <li class="add-list__item add-list__item--add">
          <input type="file" name="product-photo" id="product-photo" hidden="">
          <label for="product-photo">Добавить фотографию</label>
        </li>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple">
          <?php foreach($categories as $category) : ?>
            <option <?= isset($product) ?  (in_array($category['name'], $productCategories) ? 'selected' : '') : "" ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?= isset($product) && $product['new'] == 1 ? 'checked=""' : "" ?>>
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?= isset($product) && $product['sale'] == 1 ? 'checked=""' : "" ?>>
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <p class="custom_form__error-field" hidden=""></p>
    <button class="button" type="submit" data-id="<?= isset($product) ? $product['id'] : "" ?>"><?= isset($product) ? "Изменить товар" : "Добавить товар" ?></button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно <?= isset($product) ? "изменен" : "добавлен" ?></h2>
    </div>
  </section>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
</body>
</html>
