<?php
include('../db_connection.php');

// Get all performance reviews for the table
$reviews_sql = "SELECT pr.id, e.first_name, e.last_name, pr.review_text, pr.review_date 
                FROM performance_reviews pr
                JOIN employees e ON pr.employee_id = e.id";
$reviews_result = $conn->query($reviews_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Performance Reviews</h2>

        <!-- Success or Error Message -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="alert alert-success">Review deleted successfully.</div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="alert alert-danger">Error deleting the review.</div>
        <?php endif; ?>

        <!-- Performance Reviews Table -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Review Text</th>
                    <th>Review Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($review = $reviews_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($review['first_name'] . ' ' . $review['last_name']) ?></td>
                        <td><?= htmlspecialchars($review['review_text']) ?></td>
                        <td><?= htmlspecialchars($review['review_date']) ?></td>
                        <td>
                            <!-- View Button -->
                            <a href="view.php?id=<?= $review['id'] ?>" class="btn btn-info btn-sm">View</a>
                            <!-- Edit Button -->
                            <a href="edit.php?id=<?= $review['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <!-- Delete Button -->
                            <a href="delete.php?delete_id=<?= $review['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
