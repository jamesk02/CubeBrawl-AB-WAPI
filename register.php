<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo 'CubeBrawl Web API / POST requests only';
        return;
    }

    if (!isset($_POST['username'])) {
        echo 'Username not set';
        return;
    }

    if (!isset($_POST['password'])) {
        echo 'Password not set';
        return;
    }

    $username = $_POST['username'];
    $pwd = $_POST['password'];

    echo 'Your username is ' . $username . "\n";
    echo 'Your password is ' . $pwd;
?>