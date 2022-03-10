<?php
    // Takes the username from the session and assigns their user id to the session
    
    mysqli_report(MYSQLI_REPORT_STRICT);

    $sql = "SELECT userID FROM Credentials WHERE username = ?";
    $userID = 0; // default

    if (!isset($_SESSION['username'])) {
        http_response_code(500);
        exit('error fetching user id from username: username not found in session, not authenticated?');
    }

    $username = $_SESSION['username'];


    if ($stmt = mysqli_prepare($link, $sql)) {
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
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
        echo(mysqli_error($link));
        echo('wtf ');
        exit('error preparing select user id statement');
    }

    $stmt->close();
?>