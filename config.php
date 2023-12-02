<?php
    $host = "localhost";
    $username = "root";
    $password = "user";
    $dbname = "platinumsongs";

    $conn = mysqli_connect($host, $username, $password, $dbname);
    if(!$conn){
        echo 'Cant Connect to database';
    }
    

?>