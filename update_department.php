<?php
include('../db_connection.php');

// Get the department ID from the URL
$department_id = $_GET['id'];

// Fetch the department details
$sql = "SELECT * FROM departments WHERE id = $department_id";
$result = $conn->query($sql);
$department = $result->fetch_assoc();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $department_name = $_POST['department_name'];
    $location = $_POST['location'];

    // Update the department details
    $sql = "UPDATE departments SET department_name = '$department_name', location = '$location' WHERE id = $department_id";

    if ($conn->query($sql) === TRUE) {
        echo "Department updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h2>Update Department</h2>
    <form action="update_department.php?id=<?php echo $department['id']; ?>" method="POST">
        <label>Department Name:</label>
        <input type="text" name="department_name" value="<?php echo $department['department_name']; ?>" required><br><br>
        <label>Location:</label>
        <input type="text" name="location" value="<?php echo $department['location']; ?>" required><br><br>
        <button type="submit" name="submit">Update Department</button>
    </form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
