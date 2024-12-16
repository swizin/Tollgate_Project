<?php 
// Database connection
$conn = mysqli_connect("localhost", "root", "", "empregister", "3307");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Print the $_POST array to check form submission (optional)
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit; // Uncomment to inspect $_POST data without processing further

    // Ensure all fields are set before inserting
    if (isset($_POST['FirstName'], $_POST['LastName'], $_POST['EmployeeID'],
        $_POST['JobTitle'], $_POST['Email'], $_POST['Password'])) {
        // Collect and escape form data  
        $FirstName = mysqli_real_escape_string($conn, $_POST['FirstName']);
        $LastName = mysqli_real_escape_string($conn, $_POST['LastName']);
        $EmployeeID = mysqli_real_escape_string($conn, $_POST['EmployeeID']);
        $JobTitle = mysqli_real_escape_string($conn, $_POST['JobTitle']);
        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
        $Password = mysqli_real_escape_string($conn, $_POST['Password']);

        //SQL query to insert data
        $sql = "INSERT INTO toll_employee (FirstName, LastName, EmployeeID, JobTitle, Email, Password) 
        VALUES ('$FirstName', '$LastName', '$EmployeeID', '$JobTitle', '$Email', '$Password')";
        

             // Execute query
        if (mysqli_query($conn, $sql)) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: All fields are required.";
    }

    // Close the connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Tollgate Employee Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="SignUp">
        <h1>Tollgate Employee Sign Up</h1>

        <form method="POST">
        
            <lable>First Name</lable>
            <input type="text" name="FirstName" required>
            <lable>Last Name</lable>
            <input type="text" name="LastName" required>
            <lable>Employee ID</lable>
            <input type="text" name="EmployeeID" required>
            <lable>Job Title</lable>
            <input type="text" name="JobTitle" required>
            <lable>Email</lable>
            <input type="Email" name="Email" required>
            <lable>Password</lable>
            <input type="Password" name="Password" required>
            <input type="Submit" name="" value="Submit">
        </form>
        <p>By clicking the Sign Up button, you agree to our<br>
        <a href="">Terms and Conditions</a> and <a href="#">Policy Privacy</a></P></a>
    </p>
    <p>Already have an Account? <a href="tolllogin.php">Login Here</a></p>
    </div>
</body>
</html>