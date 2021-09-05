<?php
    if (!$_SESSION['isLoggedIn']) {
        // users must be logged in to use this API call
        http_response_code(400);
        exit('Not authenticated');
    }
?>