<?php
include('../db_connection.php');

// Handle form submission for adding a new review
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $employee_id = $_POST['employee_id'];
    $review_text = $_POST['review_text'];
    $review_date = $_POST['review_date'];

    // Insert the review into the database
    $sql = "INSERT INTO performance_reviews (employee_id, review_text, review_date) 
            VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $employee_id, $review_text, $review_date);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Performance review added successfully.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Get all employees for the dropdown list
$employees_sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM employees";
$employees_result = $conn->query($employees_sql);

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
    <title>Create Performance Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Performance Review</h2>

        <!-- Show success or error message -->
        <?= isset($message) ? $message : ''; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee</label>
                <select name="employee_id" class="form-control" required>
                    <option value="">Select Employee</option>
                    <?php while ($employee = $employees_result->fetch_assoc()): ?>
                        <option value="<?= $employee['id'] ?>"><?= htmlspecialchars($employee['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="review_text" class="form-label">Review Text</label>
                <textarea name="review_text" class="form-control" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="review_date" class="form-label">Review Date</label>
                <input type="date" name="review_date" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit Review</button>
        </form>

        <!-- Performance Reviews Table -->
        <h3 class="mt-5">Existing Performance Reviews</h3>
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
                            <a href="delete.php?id=<?= $review['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <!-- Back button -->
<a href="../home/index.php" class="btn btn-secondary mb-4">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
