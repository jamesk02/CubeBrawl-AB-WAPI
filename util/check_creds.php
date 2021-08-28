<?php
    // Checks if the username parameter is fulfilled
    if (!isset($_POST['username'])) {
        echo 'Username not set';
        return;
    }

    // Checks if the password parameter is fulfilled
    if (!isset($_POST['password'])) {
        echo 'Password not set';
        return;
    }
?>