<?php
$servername = "localhost";
$username = "Ahmed";
$password = "a#2811#1303#AN";
$database = "management_system";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
