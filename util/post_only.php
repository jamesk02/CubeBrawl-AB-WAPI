<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo 'CubeBrawl Web API / POST requests only';
        return;
    }
?>