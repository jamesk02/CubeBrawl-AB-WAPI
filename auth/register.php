<?php
    require_once("header.php");
    require_once("util/post_only.php");
    require_once("util/check_creds.php");

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
                    //echo 'userID ' . $userID;
                } else {
                    http_response_code(500);
                    exit('error selecting user id');
                }
            } else {
                http_response_code(500);
                exit('error preparing select user id statement');
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
                } else {
                    http_response_code(500);
                    exit('error configuring user data');
                }
            } else {
                http_response_code(500);
                exit('error setting up userdata insert');
            }

            $stmt->close();

            $_SESSION['username'] = $username;
            $_SESSION['isLoggedIn'] = true;

            exit('Sign up success');
        } else {
            http_response_code(500);
            exit('Error registering user.');
        }
    } else {
        http_response_code(500);
        exit('error');
    }
?>