<?php

    // Connect to MySQL database

    $user = getenv('MYSQL_USER');
    $pwd = getenv('MYSQL_PASSWORD');
    $inst = '/cloudsql/cubebrawl:europe-west2:sql-instance';

    $link = mysqli_connect(null, $user, $pwd, 'CubeBrawlDB', null, $inst);

    // Check connection
    if($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>