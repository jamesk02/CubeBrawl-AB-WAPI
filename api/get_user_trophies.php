<?php
    require_once("header.php");
    require_once("util/auth_only.php");
    require_once("util/get_only.php");

    if (!isset($_SESSION['trophies'])) {
        http_response_code(400);
        echo('Error retrieving trophies, maybe user account is corrupt');
    }
    
    http_response_code(200);
    echo($_SESSION['trophies']);
?>