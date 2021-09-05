<?php
    // Takes the username from the session and assigns their user id to the session

    $sql = "SELECT userID FROM Credentials WHERE username = ?";
    $userID = 0; // default

    if (!isset($_SESSION['username'])) {
        http_response_code(500);
        exit('error fetching user id from username: username not found in session, not authenticated?');
    }

    $username = $_SESSION['username'];

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);

        if (mysqli_stmt_execute($stmt)) {
            $stmt->store_result();
            $stmt->bind_result($userID);

            $stmt->fetch();

            $_SESSION['userID'] = $userID;
        } else {
            http_response_code(500);
            exit('error selecting user id');
        }
    } else {
        http_response_code(500);
        exit('error preparing select user id statement');
    }

    $stmt->close();
?>