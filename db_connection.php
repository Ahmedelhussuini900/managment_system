<?php
$servername = "localhost";
$username = "Ahmed";  // Replace with your MySQL username
$password = "a#2811#1303#AN";      // Replace with your MySQL password
$dbname = "managment_system"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // Uncomment for testing
?>
