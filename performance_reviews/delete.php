<?php
include('../db_connection.php');

// Handle the delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete the review from the database
    $delete_sql = "DELETE FROM performance_reviews WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $delete_id);

    if ($delete_stmt->execute()) {
        // Redirect to the view page with a success message
        header("Location: view.php?success=1"); 
        exit;
    } else {
        // Redirect to the view page with an error message
        header("Location: view.php?error=1"); 
        exit;
    }
    $delete_stmt->close();
}

$conn->close();
?>
