<?php
include 'config.php';

$sql = "SELECT pr.id, CONCAT(e.first_name, ' ', e.last_name) AS employee_name, pr.rating, pr.comment, pr.review_date 
        FROM performance_reviews pr
        JOIN employees e ON pr.employee_id = e.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Performance Reviews</title>
</head>
<body>
    <h1>Performance Reviews</h1>
    <a href="create.php">Add New Review</a>
    <table border="1">
        <tr>
            <th>Review ID</th>
            <th>Employee Name</th>
            <th>Rating</th>
            <th>Comments</th>
            <th>Review Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['employee_name']) ?></td>
            <td><?= htmlspecialchars($row['rating']) ?></td>
            <td><?= htmlspecialchars($row['comment']) ?></td>
            <td><?= htmlspecialchars($row['review_date']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
