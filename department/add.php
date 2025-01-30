<?php
include('../db_connection.php');

// Handle department creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    // Get form input data
    $department_name = $_POST['department_name'];
    $location = $_POST['location'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO departments (department_name, location) VALUES (?, ?)");
    $stmt->bind_param("ss", $department_name, $location);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>New department added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
}

// Fetch departments for display
$sql = "SELECT * FROM departments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Create New Department</h2>

    <!-- Form for creating new department -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="department_name" class="form-label">Department Name:</label>
            <input type="text" name="department_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location:</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="text-center">
            <input type="submit" name="create" value="Create Department" class="btn btn-success">
        </div>
    </form>

    <hr>

    <!-- Display existing departments -->
    <h3 class="mt-4">Existing Departments</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Using PHP echo for dynamic URLs
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['department_name'] . "</td>
                            <td>" . $row['location'] . "</td>
                            <td>
                                <a href='update_department.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                <a href='./delete_department.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' \")'>Delete</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No departments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Back button -->
<a href="../home/index.php" class="btn btn-secondary mb-4">Back</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

<?php

$conn->close();
?>
