​<?php

include "dbconfig.php";

if (isset($_GET['id'])) {
    $emp_id = $_GET['id'];
    $sql = "DELETE FROM emplyees WHERE id =$emp_id";
     $result = $conn->query($sql);
     if ($result == TRUE) {
        echo "Record deleted successfully.";
        header('Location: view.php');
    }else{
        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}

?>