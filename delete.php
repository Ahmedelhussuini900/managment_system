<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM performance_reviews WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
    header("Location: list.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}
?>

