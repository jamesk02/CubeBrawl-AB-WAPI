<?php
    require_once("header.php");
    require_once("auth_only.php");
    require_once("get_only.php");

    exit($_SESSION['gems']);
?>