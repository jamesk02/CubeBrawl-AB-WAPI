<?php
    require_once "db_config.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo 'CubeBrawl Web API / POST requests only';
        return;
    }

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

    // Assign appropriate variables to parameters
    $username = $_POST['username'];
    $pwd = $_POST['password'];

    echo 'Your username is ' . $username . "\n";
    echo 'Your password is ' . $pwd;


    $sql = "INSERT INTO Credentials(username, passwordHash, passwordSalt) VALUES (?, ?, ?)";
?>