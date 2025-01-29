<?php
include 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM performance_reviews WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$employees = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM employees");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $review_date = $_POST['review_date'];

    $update_sql = "UPDATE performance_reviews 
                   SET employee_id='$employee_id', rating='$rating', comment='$comment', review_date='$review_date' 
                   WHERE id='$id'";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: list.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Performance Review</title>
</head>
<body>
    <h1>Edit Performance Review</h1>
    <form method="POST">
        <label>Employee:</label>
        <select name="employee_id" required>
            <?php while ($emp = $employees->fetch_assoc()): ?>
                <option value="<?= $emp['id'] ?>" <?= $emp['id'] == $row['employee_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($emp['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <label>Rating (1-5):</label>
        <input type="number" name="rating" value="<?= $row['rating'] ?>" min="1" max="5" required>
        <br><br>
        <label>Comments:</label>
        <textarea name="comment"><?= htmlspecialchars($row['comment']) ?></textarea>
        <br><br>
        <label>Review Date:</label>
        <input type="date" name="review_date" value="<?= $row['review_date'] ?>" required>
        <br><br>
        <button type="submit">Update Review</button>
    </form>
</body>
</html>

