<?php

if ($_SESSION['isUserAuthorize'] === false) {
    header("HTTP/1.0 401 Unauthorize");
}