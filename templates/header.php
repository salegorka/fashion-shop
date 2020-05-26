<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/include/menu/menuFunction.php'; ?>
<?php $menuList = getMenuList($_SESSION['isUserAuthorize']); 
    $activeIndex = getActiveItemKey($menuList);
?>
<header class="page-header">
  <a class="page-header__logo" href="/">
    <img src="/img/logo.svg" alt="Fashion">
  </a>
  <nav class="page-header__menu">
    <ul class="main-menu main-menu--header">
      <?php foreach($menuList as $key => $item): ?>
        <li>
            <a class="<?= $key === $activeIndex ? "main-menu__item active" : "main-menu__item" ?>" href="<?= $item[1] ?>"><?= $item[0] ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
</header>