<?php
    /* This file is used to sync the user's data after authentication
     * So it will get coins, gems, trophies, username and store them in the session as long as
     * authentication has been done
     *
     * Only needs a user id in session, once that's been done we can assign all other values to session
     */

    require("util/get_only.php");
    require("util/auth_only.php");

    // Login won't have the user ID so fetch that for them, register already will have it
    require("get_user_id_from_username.php");
    $userID = $_SESSION['userID'];

    $sql = 'SELECT coins, gems, trophies FROM UserData WHERE userID = ?';

    if ($stmt = mysqli_prepare($link, $sql)) {
        $stmt->bind_param("i", $userID);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($coins, $gems, $trophies);

            while ($stmt->fetch()) {
                $_SESSION['coins'] = $coins;
                $_SESSION['gems'] = $gems;
                $_SESSION['trophies'] = $trophies;
            }
        } else {
            http_response_code(500);
            exit('error executing fetch user data statement');
        }
    } else {
        http_response_code(500);
        exit('error preparing fetch user data statement');
    }



?>