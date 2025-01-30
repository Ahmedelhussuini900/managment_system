<?php
include('../db_connection.php');

// Initialize success message as empty
$successMessage = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch department details
    $sql = "SELECT * FROM departments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    // Execute and check if the department exists
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "No department found for ID: " . $id;  // More informative error message
            exit();
        }
    } else {
        echo "Error executing query: " . $stmt->error;  // Error while executing the query
        exit();
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $department_name = $_POST['department_name'];
        $location = $_POST['location'];

        // Update department in the database
        $update_sql = "UPDATE departments SET department_name = ?, location = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $department_name, $location, $id);

        if ($update_stmt->execute()) {
            // Set success message and reset form values
            $successMessage = "Department updated successfully!";
            $row['department_name'] = $department_name;
            $row['location'] = $location;
        } else {
            echo "<div class='alert alert-danger'>Error: " . $update_stmt->error . "</div>";
        }
    }
} else {
    echo "Invalid department ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Department</h2>

    <!-- Success message display -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="department_name" class="form-label">Department Name:</label>
            <input type="text" name="department_name" class="form-control" value="<?= htmlspecialchars($row['department_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location:</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($row['location']) ?>" required>
        </div>
        <div class="text-center">
            <input type="submit" name="update" value="Update Department" class="btn btn-success">
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
