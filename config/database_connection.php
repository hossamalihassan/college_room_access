<?php 

    define('DB_HOST', 'localhost:3307');
    define('DB_USER', 'admin');
    define('DB_PASS', '');
    define('DB_NAME', 'college');

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($conn->connect_error){
        die("connection failed");
    }

?>