<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $review_date = $_POST['review_date'];

    $sql = "INSERT INTO performance_reviews (employee_id, rating, comment, review_date) 
            VALUES ('$employee_id', '$rating', '$comment', '$review_date')";
    if ($conn->query($sql) === TRUE) {
        header("Location: list.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$employees = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM employees");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Performance Review</title>
</head>
<body>
    <h1>Create Performance Review</h1>
    <form method="POST">
        <label>Employee:</label>
        <select name="employee_id" required>
            <option value="">Select Employee</option>
            <?php while ($emp = $employees->fetch_assoc()): ?>
                <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <label>Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required>
        <br><br>
        <label>Comments:</label>
        <textarea name="comment"></textarea>
        <br><br>
        <label>Review Date:</label>
        <input type="date" name="review_date" required>
        <br><br>
        <button type="submit">Create Review</button>
    </form>
</body>
</html>
