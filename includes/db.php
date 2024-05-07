<?php 

    $servername = "localhost";
    $username = "u227156034_user";
    $password = "8@?PVqF@PpU";
    $dbname = "u227156034_examination";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
