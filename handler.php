<?php
/*
 * This handler allows us to only pick and choose which files we give access to
 * an external user. We have to bear in mind that a potential attacker can access
 * any endpoint we whitelist here. The rest is accessible only to the server itself.
 */
ini_set('allow_url_fopen', 1);
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/startSession':
        require 'header.php';
        break;
    // AUTH
    case '/register':
        require 'auth/register.php';
        break;
    case '/login':
        require 'auth/login.php';
        break;
    // API
    case '/api/user/getCoins':
        require 'api/get_user_coins.php';
        break;
    case '/api/user/getGems':
        require 'api/get_user_gems.php';
        break;
    case '/api/user/getTrophies':
        require 'api/get_user_trophies.php';
        break;
    // 404
    default:
        http_response_code(404);
        exit('CubeBrawl Web API / 404 Not Found');
}
?>
