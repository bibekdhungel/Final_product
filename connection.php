<?php 
    $servername = "localhost";
    $username = "root"; // XAMPP default username
    $password = ""; // XAMPP default password is empty
    $db_name = "project";  
    $conn = new mysqli($servername, $username, $password, $db_name);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    echo "";
?>
