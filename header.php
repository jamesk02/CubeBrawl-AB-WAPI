<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    require_once "auth/db_config.php";




    /*if (isset($_SESSION['isLoggedIn']) && isset($_SESSION['username'])) {
        if ($_SESSION['isLoggedIn']) {
            echo 'Logged in as ' . $_SESSION['username'] . '.';
        } else {
            echo 'isLoggedIn = ' . $_SESSION['isLoggedIn'];
        }
    }*/
?>