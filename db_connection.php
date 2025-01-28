<?php
$servername = "localhost";
$username = "Ahmed";  
$password = "a#2811#1303#AN";     
$dbname = "managment_system"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully"; 
?>
