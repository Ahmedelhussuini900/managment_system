<?php
include "../db_connection.php";

// Fetch departments for the dropdown
$departments = [];
$sql = "SELECT id, department_name FROM departments";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}

// Add new employee
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_employee'])) {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $hireDate = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $departmentID = $_POST['department_id'];
    $jobTitle = trim($_POST['job_title']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif ($salary <= 0) {
        $error = "Salary must be a positive number!";
    } else {
        $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, email, hire_date, salary, department_id, job_title) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdis", $firstName, $lastName, $email, $hireDate, $salary, $departmentID, $jobTitle);

        if ($stmt->execute()) {
            $success = "Employee added successfully!";
            // Redirect to employee list after successful addition
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all employees
$employees = [];
$sql = "SELECT e.id, e.first_name, e.last_name, e.email, e.hire_date, e.salary, e.job_title, d.department_name 
        FROM employees e
        JOIN departments d ON e.department_id = d.id";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

// Delete employee
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteStmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $deleteStmt->bind_param("i", $deleteId);
    if ($deleteStmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
    }
    $deleteStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Create New Employee</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card p-4 shadow mb-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">First Name:</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name:</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Hire Date:</label>
                <input type="date" name="hire_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Salary:</label>
                <input type="number" step="0.01" name="salary" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department:</label>
                <select name="department_id" class="form-control" required>
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>"><?= $dept['department_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Job Title:</label>
                <input type="text" name="job_title" class="form-control" required>
            </div>

            <button type="submit" name="add_employee" class="btn btn-primary w-100">Create Employee</button>
        </form>
    </div>

    <h2 class="text-center mt-5 mb-4">Employee List</h2>

    <!-- Employee Table -->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Hire Date</th>
                <th>Salary</th>
                <th>Department</th>
                <th>Job Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($employees) > 0): ?>
                <?php foreach ($employees as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['hire_date']; ?></td>
                        <td>$<?php echo number_format($row['salary'], 2); ?></td>
                        <td><?php echo $row['department_name']; ?></td>
                        <td><?php echo $row['job_title']; ?></td>
                        <td>
                            <!-- View Button -->
                            <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                            <!-- Delete Button -->
                            <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this employee?');" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center">No employees found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Back button -->
<a href="../home/index.php" class="btn btn-secondary mb-4">Back</a>
</div>

</body>
</html>
