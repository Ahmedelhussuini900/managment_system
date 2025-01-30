
<?php
include('../db_connection.php');

// Get the department ID from the URL
$department_id = $_GET['id'];

// Delete the department
$sql = "DELETE FROM departments WHERE id = $department_id";

if ($conn->query($sql) === TRUE) {
    echo "Department deleted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Redirect to the view page
header('Location: view_departments.php');
exit;
?>
