<?php
include "dbconfig.php";

if (isset($_GET['id'])) {
    $emp_id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE id='$emp_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $email = $row['email'];
            $hireDate = $row['hireDate'];
            $salary = $row['salary'];
            $departmentID = $row['DepartmentID'];
            $jobTitle = $row['jobTitle'];
        }
?>

        <h2>Employee Details Update Form</h2>
        <form action="" method="post">
            <fieldset>
                <legend>Employee Information:</legend>
                First Name:<br>
                <input type="text" name="firstName" value="<?php echo $firstName; ?>">
                <input type="hidden" name="emp_id" value="<?php echo $id; ?>">
                <br>
                Last Name:<br>
                <input type="text" name="lastName" value="<?php echo $lastName; ?>">
                <br>
                Email:<br>
                <input type="email" name="email" value="<?php echo $email; ?>">
                <br>
                Hire Date:<br>
                <input type="date" name="hireDate" value="<?php echo $hireDate; ?>">
                <br>
                Salary:<br>
                <input type="number" name="salary" value="<?php echo $salary; ?>">
                <br>
                Department ID:<br>
                <input type="number" name="DepartmentID" value="<?php echo $departmentID; ?>">
                <br>
                Job Title:<br>
                <input type="text" name="jobTitle" value="<?php echo $jobTitle; ?>">
                <br><br>
                <input type="submit" value="Update" name="update">
            </fieldset>
        </form>

<?php
    } else {
        header('Location: view-employees.php');
    }
}

if (isset($_POST['update'])) {
    $emp_id = $_POST['emp_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $hireDate = $_POST['hireDate'];
    $salary = $_POST['salary'];
    $departmentID = $_POST['DepartmentID'];
    $jobTitle = $_POST['jobTitle'];

    $sql = "UPDATE employees SET firstName='$firstName', lastName='$lastName', email='$email', hireDate='$hireDate', salary=$salary, DepartmentID=$departmentID, jobTitle='$jobTitle' WHERE id=$emp_id";
    $result = $conn->query($sql);

    if ($result == TRUE) {
        echo "Record updated successfully.";
        header('Location: view.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>