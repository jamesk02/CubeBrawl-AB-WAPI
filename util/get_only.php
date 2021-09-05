<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo 'CubeBrawl Web API / POST requests only';
        return;
    }
?>