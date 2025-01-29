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

// Handle department update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];
    $location = $_POST['location'];

    // Update the department
    $stmt = $conn->prepare("UPDATE departments SET department_name = ?, location = ? WHERE id = ?");
    $stmt->bind_param("ssi", $department_name, $location, $department_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Department updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
}

// Handle department deletion
if (isset($_GET['delete'])) {
    $department_id = $_GET['delete'];

    // Delete the department
    $stmt = $conn->prepare("DELETE FROM departments WHERE id = ?");
    $stmt->bind_param("i", $department_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Department deleted successfully.</div>";
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
    <title>Manage Departments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Departments</h2>

    <!-- Form for inserting/updating data into the departments table -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="department_name" class="form-label">Department Name:</label>
            <input type="text" name="department_name" id="department_name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="location" class="form-label">Location:</label>
            <input type="text" name="location" id="location" class="form-control" required>
        </div>
        
        <div class="text-center">
            <input type="submit" name="create" value="Insert Department" class="btn btn-primary">
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
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['department_name'] . "</td>
                            <td>" . $row['location'] . "</td>
                            <td>
                                <a href='#' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#updateModal' 
                                   data-id='" . $row['id'] . "' data-name='" . $row['department_name'] . "' data-location='" . $row['location'] . "'>Edit</a>
                                <a href='?delete=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
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

<!-- Modal for updating department -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">
            <input type="hidden" name="department_id" id="department_id">
            <div class="mb-3">
                <label for="update_department_name" class="form-label">Department Name:</label>
                <input type="text" name="department_name" id="update_department_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="update_location" class="form-label">Location:</label>
                <input type="text" name="location" id="update_location" class="form-control" required>
            </div>
            <div class="text-center">
                <input type="submit" name="update" value="Update Department" class="btn btn-primary">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    // Populate the update modal with existing data
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var departmentId = button.getAttribute('data-id');
        var departmentName = button.getAttribute('data-name');
        var departmentLocation = button.getAttribute('data-location');

        var modalDepartmentId = updateModal.querySelector('#department_id');
        var modalDepartmentName = updateModal.querySelector('#update_department_name');
        var modalLocation = updateModal.querySelector('#update_location');

        modalDepartmentId.value = departmentId;
        modalDepartmentName.value = departmentName;
        modalLocation.value = departmentLocation;
    });
</script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
