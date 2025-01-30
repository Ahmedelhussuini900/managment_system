<?php
include "../db_connection.php";

if (isset($_GET['id'])) {
    $emp_id = intval($_GET['id']); 

    
    $check_sql = "SELECT * FROM employees WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $emp_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
    
        $sql = "DELETE FROM employees WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $emp_id);

        if ($stmt->execute()) {
            echo "<script>
                alert('Employee deleted successfully!');
                window.location.href='view.php';
            </script>";
        } else {
            echo "<script>alert('Error: Could not delete employee.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error: Employee not found.'); window.location.href='view.php';</script>";
    }

    $check_stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='view.php';</script>";
}
?>
