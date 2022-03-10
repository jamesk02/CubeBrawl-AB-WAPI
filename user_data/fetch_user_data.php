<?php
    /* This file is used to sync the user's data after authentication
     * So it will get coins, gems, trophies, username and store them in the session as long as
     * authentication has been done
     *
     * The key difference between this and api/get_user_data is that this loads the data into the session
     * which is used when authenticating whereas api/get_user_data is for when we're already authenticated,
     * such as in game when checking to see if we can afford a certain item
     *
     * Only needs a user id in session, once that's been done we can assign all other values to session
     */

    require("util/auth_only.php");

    // Login won't have the user ID so fetch that for them, register already will have it
    require("get_user_id_from_username.php");
    $userID = $_SESSION['userID'];

    $sql = 'SELECT coins, gems, trophies FROM UserData WHERE userID = ?';

    if (!isset($userID)) {
        http_response_code(500);
        exit('Error fetching user ID');
    }

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