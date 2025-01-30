<?php
include "../db_connection.php";

// Fetch all employees
$sql = "SELECT e.id, e.first_name, e.last_name, e.email, e.hire_date, e.salary, e.job_title, d.department_name 
        FROM employees e
        JOIN departments d ON e.department_id = d.id";
$result = $conn->query($sql);

$employees = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        h2 {
            color: #4E9CAF;
            font-weight: bold;
            text-align: center;
        }

        .table {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            padding: 12px;
            text-align: center;
        }

        .table th {
            background-color: #4E9CAF;
            color: white;
            font-weight: bold;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn-custom {
            background-color: #4E9CAF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #2e7a7f;
        }

        .action-buttons a {
            text-decoration: none;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Employee List</h2>

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
            <?php
            if (count($employees) > 0) {
                foreach ($employees as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['hire_date']; ?></td>
                        <td>$<?php echo number_format($row['salary'], 2); ?></td>
                        <td><?php echo $row['department_name']; ?></td>
                        <td><?php echo $row['job_title']; ?></td>
                        <td class="action-buttons d-flex justify-content-center">
   
    <a href="update.php?id=<?php echo $row['id']; ?>" class="me-2">
        <button class="btn-custom">Edit</button>
    </a>
  
    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this employee?');">
        <button class="btn-custom">Delete</button>
    </a>
</td>

                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No employees found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
