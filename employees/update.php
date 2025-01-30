<?php
include "../db_connection.php";

if (isset($_GET['id'])) {
    $emp_id = intval($_GET['id']); // Input sanitization
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $emp_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
        $email = $row['email'];
        $hireDate = $row['hire_date'];
        $salary = $row['salary'];
        $departmentID = $row['department_id'];
        $jobTitle = $row['job_title'];
    } else {
        echo "<script>alert('Employee not found!'); window.location.href='view.php';</script>";
        exit();
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = intval($_POST['emp_id']);
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $hireDate = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $departmentID = $_POST['department_id'];
    $jobTitle = $_POST['job_title'];

    $update_sql = "UPDATE employees SET first_name = ?, last_name = ?, email = ?, hire_date = ?, salary = ?, department_id = ?, job_title = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssdisi", $firstName, $lastName, $email, $hireDate, $salary, $departmentID, $jobTitle, $emp_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Employee updated successfully!'); window.location.href='./view.php';</script>";
    } else {
        echo "<script>alert('Error updating record!');</script>";
    }
    $update_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../home/style.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid mt-5">
    <h2 class="text-center mb-4">Edit Employee</h2>

    <div class="card p-4 shadow w-100">
        <form method="POST" action="">
            <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">

            <div class="mb-3">
                <label class="form-label">First Name:</label>
                <input type="text" name="first_name" value="<?php echo $firstName; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $lastName; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Hire Date:</label>
                <input type="date" name="hire_date" value="<?php echo $hireDate; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Salary:</label>
                <input type="number" step="0.01" name="salary" value="<?php echo $salary; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Department ID:</label>
                <input type="number" name="department_id" value="<?php echo $departmentID; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Job Title:</label>
                <input type="text" name="job_title" value="<?php echo $jobTitle; ?>" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Employee</button>
        </form>
    </div>
</div>

</body>
</html>
