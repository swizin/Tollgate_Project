<?php
session_start();

include("vehdbcon.php"); // Ensure the file path is correct

// Database configuration
$host = "localhost";  // Change to your host if not localhost
$username = "root";   // Your MySQL username
$password = "";       // Your MySQL password
$dbname = "vehicle_ownerdb"; // Your database name
$port = 3307;         // Update port if it's different

// Create connection
$con = mysqli_connect($host, $username, $password, $dbname, $port);

// Check connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['Email'], $_POST['Password'])) {
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];

        if (!empty($Email) && !empty($Password) && !is_numeric($Email)) {
            // Query to check if the user exists
            $query = "SELECT * FROM vehicleregister WHERE Email = ? LIMIT 1";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "s", $Email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['Password'] === $Password) {
                    // Store user data in session variables
                    $_SESSION['user_id'] = $user_data['id']; // Assuming the table has an 'id' column
                    $_SESSION['user_name'] = $user_data['Name']; // Assuming the table has a 'Name' column
                    $_SESSION['user_email'] = $user_data['Email'];

                    // Redirect to the dashboard
                    header("Location: vehdashboard.php");
                    exit();
                } else {
                    echo "<script type='text/javascript'>alert('Incorrect password.');</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('No user found with that email.');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Invalid email or password format.');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('All fields are required');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Owner Login</title>
    <link rel="stylesheet" href="styles.css">
</head>  
<body>
    <div class="SignUp">
        <h1>Login</h1>
        <h4>For Vehicle Owner</h4>
        <form method="POST" action="">
            <label>Email</label>
            <input type="email" name="Email" required>
            <label>Password</label>
            <input type="password" name="Password" required>
            <input type="submit" value="Submit">
        </form>
        <p>Not have an account? <a href="vehsignup.php">Sign Up Here</a></p>
    </div>
</body>   
</html>
