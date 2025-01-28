<html>

<head>
    <title>Add Department</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            background: white;
            padding: 20px;
            margin: 50px auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Department</h1>

         <?php
         include 'db_connection.php';

        // // Database configuration
        // $host = "localhost";
        // $username = "root";
        // $password = "";
        // $database = "management_system";

        // // Create connection
        // $conn = new mysqli($host, $username, $password, $database);

        // // Check connection
        // if ($conn->connect_error) {
        //     die("<p class='message error'>Connection failed: " . $conn->connect_error . "</p>");
        // }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $deptName = $_POST["deptName"];
            $location = $_POST["location"];

            // Insert into the departments table
            $sql = "INSERT INTO departments (department_name, location) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $deptName, $location);

            if ($stmt->execute()) {
                echo "<p class='message success'>Department added successfully!</p>";
            } else {
                echo "<p class='message error'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }

        $conn->close();
        ?> 

        <form method="POST" >
            <label for="deptName">Department Name:</label>
            <input type="text" name="deptName" required>

            <label for="location">Location:</label>
            <input type="text" name="location" required>

            <input type="submit" value="Add">
        </form>

        <a href="departments.php" class="back-link">Back to Departments</a>
    </div>
</body>

</html>
