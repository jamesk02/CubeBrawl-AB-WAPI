<?php

ini_set('allow_url_fopen', 1);
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'index.php';
        break;
    case '/index.php':
        echo "suck ya mudda";
        break;
    case '/register':
        require 'register.php';
        break;
    default:
        http_response_code(404);
        echo @parse_url($_SERVER['REQUEST_URI']['PATH']);
        exit('Not Found');
}
?>
