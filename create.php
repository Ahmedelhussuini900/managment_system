
<?php
include "dbconfig.php";

if (isset($_POST['submit'])) {

  $id = $_POST['id'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $hireDate = $_POST['hireDate'];
  $salary = $_POST['salary'];
  $DepartmentID = $_POST['DepartmentID'];
  $jobTitle = $_POST['jobTitle'];


  $sql = "INSERT INTO employees (firstName,lastName,email,hireDate,salary,DepartmentID,jobTitle) VALUES ('$firstName','$lastName','$email','$hireDate',$salary,$DepartmentID,'$jobTitle')";
  $result = $conn->query($sql);
  if ($result == TRUE) {
    echo "New record created successfully.";
    header('Location: view.php');
  }else{
    echo "Error:". $sql . "<br>". $conn->error;
  }
  $conn->close();
}



?>