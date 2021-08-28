<?php

    // Connect to MySQL database

    $user = getenv('CLOUDSQL_USER');
    $pwd = getenv('CLOUDSQL_PASSWORD');
    $inst = '/cloudsql/cubebrawl-webapi:europe-west2:sql-instance';

    $link = mysqli_connect(null, "root", "mysql", 'CubeBrawlDB', null, $inst);

    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>