<?php

ini_set('allow_url_fopen', 1);
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/register':
        require 'auth/register.php';
        break;
    case '/login':
        require 'auth/login.php';
        break;
    default:
        http_response_code(404);
        exit('CubeBrawl Web API / 404 Not Found');
}
?>
