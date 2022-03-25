<?php
    require_once("header.php");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once("util/auth_only.php");
    require_once("util/post_only.php");

    # Validation
    if (!isset($_SESSION['gems'])) {
        http_response_code(400);
        exit('Error retrieving gems, maybe user account is corrupt');
    }

    if (!isset($_SESSION['trophies'])) {
        http_response_code(400);
        exit('Error retrieving trophies, maybe user account is corrupt');
    }

    if (!isset($_SESSION['coins'])) {
        http_response_code(400);
        exit('Error retrieving coins, maybe user account is corrupt');
    }

    if (!isset($_POST['coinsAdj']) || !is_numeric($_POST['coinsAdj'])) {
        http_response_code(400);
        exit('Invalid value for coins');
    }

    if (!isset($_POST['gemsAdj']) || !is_numeric($_POST['gemsAdj'])) {
        http_response_code(400);
        exit('Invalid value for gems');
    }

    if (!isset($_POST['trophiesAdj']) || !is_numeric($_POST['trophiesAdj'])) {
        http_response_code(400);
        exit('Invalid value for trophies');
    }


    # Compute new values for stats
    $gemsToAdj = $_POST['gemsAdj'];
    $currentGems = intval($_SESSION['gems']);


    $coinsToAdj = $_POST['coinsAdj'];
    $currentCoins = intval($_SESSION['coins']);

    
    $trophiesToAdj = $_POST['trophiesAdj'];
    $currentTrophies = intval($_SESSION['trophies']);

    # Detect user ID
    $userID = $_SESSION['userID'];


    # Apply new user stats to UserData records
    $sql = "UPDATE UserData SET gems = ?, coins = ?, trophies = ? WHERE userID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "iiii", $gems, $coins, $trophies, $uID);

        $trophies = $trophiesToAdj + $currentTrophies;
        $gems = $gemsToAdj + $currentGems;
        $coins = $coinsToAdj + $currentCoins;
        $uID = $_SESSION['userID'];

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            $stmt->close();

            # Success so update session variables
            $_SESSION['gems'] = $gems;
            $_SESSION['coins'] = $coins;
            $_SESSION['trophies'] = $trophies;

            http_response_code(200);
            exit($gems . ',' . $coins . ',' . $trophies);
        } else {
            http_response_code(500);
            exit('error updating user stats');
        }
    } else {
        http_response_code(500);
        exit('error setting up user stats update');
    }
?>