<?php
    require_once("header.php");

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



    $sql = "INSERT INTO Credentials(username, passwordHash) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $pwd_hash);

        // Assign appropriate variables to parameters
        $username = $_POST['username'];
        // decided to use B Crypt, see DD here: https://www.seidengroup.com/2021/04/05/storing-passwords-safely/
        $pwd_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            //$sql = "INSERT INTO UserData(userID, coins, gems, trophies) VALUES (?, ?, ?)";

            $_SESSION['username'] = $username;
            $_SESSION['isLoggedIn'] = true;

            echo 'Sign up success';
        } else {
            echo 'Error registering user.';
        }
    } else {
        echo 'error';
    }
?>