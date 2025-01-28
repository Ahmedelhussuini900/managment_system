<?php
include('../db_connection.php');

// SQL query to fetch all departments
$sql = "SELECT * FROM departments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['department_name'] . "</td>
                <td>" . $row['location'] . "</td>
                <td>
                    <a href='update_department.php?id=" . $row['id'] . "'>Edit</a> |
                    <a href='./delete_department.php?id=" . $row['id'] . "'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No departments found.";
}

$conn->close();
?>
