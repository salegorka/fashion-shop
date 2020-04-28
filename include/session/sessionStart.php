<?php

session_name('session_id');
session_start();

if (!isset($_SESSION['isUserAuthorize'])) {
    $_SESSION['isUserAuthorize'] = false;
}
