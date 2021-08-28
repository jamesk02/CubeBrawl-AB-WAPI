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

        // TODO : Add check to see if username is taken or not

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            $stmt->close();

            // fetch user id to use as a foreign key to then insert user data
            $sql = "SELECT userID FROM Credentials WHERE username = ?";
            $userID = 0; // default
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $username);

                if (mysqli_stmt_execute($stmt)) {
                    $stmt->store_result();
                    $stmt->bind_result($userID);

                    $stmt->fetch();
                    echo 'userID ' . $userID;
                } else {
                    echo 'error selecting user id';
                }
            } else {
                echo 'error preparing select user id statement';
            }

            $stmt->close();

            // insert user data with starting values
            $sql = "INSERT INTO UserData(userID, coins, gems, trophies) VALUES (?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "iiii", $uID, $coins, $gems, $trophies);

                $uID = $userID;
                $coins = 0;
                $gems = 0;
                $trophies = 100;

                if (mysqli_stmt_execute($stmt)) {
                    // Success

                    echo 'user data configured successfully';
                } else {
                    echo 'error configuring user data';
                }
            } else {
                echo 'error setting up userdata insert';
            }

            $stmt->close();

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