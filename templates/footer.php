<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/include/menu/menuFunction.php'; ?>
<?php $menuList = getMenuList($_SESSION['isUserAuthorize']); 
?>
<footer class="page-footer">
  <div class="container">
    <a class="page-footer__logo" href="#">
      <img src="/img/logo--footer.svg" alt="Fashion">
    </a>
    <nav class="page-footer__menu">
      <ul class="main-menu main-menu--footer">
        <?php foreach($menuList as $item) : ?>
          <li>
            <a class="main-menu__item" href="<?= $item[1] ?>"><?= $item[0] ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <address class="page-footer__copyright">
      © Все права защищены
    </address>
  </div>