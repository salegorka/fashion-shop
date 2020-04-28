<?php

if ($_SESSION['isUserAuthorized'] === false) {
    header("HTTP/1.0 401 Unauthorize");
}