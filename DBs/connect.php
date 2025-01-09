<?php

function conn($servername = "localhost", $username = "root", $password = "newpassword", $databae="notino"){

    // Create connection
    $conn = new mysqli($servername, $username, $password, $databae);

    // Check connection
    if ($conn->connect_error) {
        return 0;
        // die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
