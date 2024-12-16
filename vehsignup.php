<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "vehicle_ownerdb", "3307");

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
    if (isset($_POST['DrivingLicense'], $_POST['CarNumberPlate'], $_POST['FirstName'], $_POST['LastName'], 
    $_POST['Email'], $_POST['Password'])) {
        // Collect and escape form data
        $DrivingLicense = mysqli_real_escape_string($conn, $_POST['DrivingLicense']);
        $CarNumberPlate = mysqli_real_escape_string($conn, $_POST['CarNumberPlate']);
        $FirstName = mysqli_real_escape_string($conn, $_POST['FirstName']);
        $LastName = mysqli_real_escape_string($conn, $_POST['LastName']);
        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
        $Password = mysqli_real_escape_string($conn, $_POST['Password']);

        // SQL query to insert data
        $sql = "INSERT INTO vehicleregister (`DrivingLicense`, `CarNumberPlate`, `FirstName`, `LastName`, `Email`, `Password`) 
                VALUES ('$DrivingLicense', '$CarNumberPlate', '$FirstName', '$LastName', '$Email', '$Password')";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Owner Registration</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function togglePassword() {
            var passwordField = document.querySelector('input[name="Password"]');
            var showPasswordCheckbox = document.querySelector('#showPassword');
            passwordField.type = showPasswordCheckbox.checked ? "text" : "password";
        }
    </script>
</head>
<body>
<div style="display: flex; justify-content: left; gap: 20px; margin: 20px 0;">
        <img src="images/pic2.jpg" alt="First Image" style="width: 150%; max-width: 600px; border-radius: 10px;">
        <img src="images/pic9.jpg" alt="Second Image" style="width: 100%; max-width: 400px; border-radius: 10px;">
    </div>
    
    <div class="SignUp">
        <h1>Vehicle Owner Sign Up</h1>
    
        <form method="POST" action="vehsignup.php">
    <label>Driving License</label>
    <input type="text" name="DrivingLicense" required>
    
    <label>Car Number Plate</label>
    <input type="text" name="CarNumberPlate" required>
    
    <label>First Name</label>
    <input type="text" name="FirstName" required>
    
    <label>Last Name</label>
    <input type="text" name="LastName" required>
    
    <label>Email</label>
    <input type="email" name="Email" required>
    
    <label>Password</label>
    <input type="password" name="Password" required>
    
    <input type="submit" value="Submit">
        </form>

        
        <p>You can also Sign Up using the mobile App<br>
        <a href="https://form.jotform.com/243442405202544">Using Our Mobile Apllication</a> and <a href="https://form.jotform.com/243442405202544">Privacy Policy</a>.</p>
        
        <p>Already have an account? <a href="vehlogin.php">Login Here</a></p>
    </div>
</body>
</html>
