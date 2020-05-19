<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/session/sessionStart.php';

session_destroy();
unset($_SESSION['isUserAuthorize']);
setcookie('session_id', '', time() - 3);
header('Location: /');