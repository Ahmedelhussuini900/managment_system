<?php
include('../db_connection.php');

// Fetch the existing review data
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    $edit_sql = "SELECT * FROM performance_reviews WHERE id = ?";
    $edit_stmt = $conn->prepare($edit_sql);
    $edit_stmt->bind_param("i", $edit_id);
    $edit_stmt->execute();
    $edit_result = $edit_stmt->get_result();
    $edit_review = $edit_result->fetch_assoc();

    // Handle update form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_review'])) {
        $updated_review_text = $_POST['review_text'];
        $updated_review_date = $_POST['review_date'];

        // Update the review in the database
        $update_sql = "UPDATE performance_reviews SET review_text = ?, review_date = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $updated_review_text, $updated_review_date, $edit_id);

        if ($update_stmt->execute()) {
            header("Location: view.php"); // Redirect to view page after updating
            exit;
        }
        $update_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Performance Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Performance Review</h2>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="review_text" class="form-label">Review Text</label>
                <textarea name="review_text" class="form-control" rows="5" required><?= htmlspecialchars($edit_review['review_text']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="review_date" class="form-label">Review Date</label>
                <input type="date" name="review_date" class="form-control" value="<?= $edit_review['review_date'] ?>" required>
            </div>
            <button type="submit" name="update_review" class="btn btn-primary">Update Review</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
