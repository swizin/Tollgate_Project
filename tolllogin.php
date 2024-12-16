<?php
session_start();

include("tolldbcon.php");  // Ensure the file path is correct
// tolldbcon.php
$host = "localhost";  // Change to your host if not localhost
$username = "root";   // Your MySQL username
$password = "";       // Your MySQL password
$dbname = "empregister"; // Your database name
$port = 3307;         // Update port if it's different, e.g., 3307 for XAMPP with a custom port

// Create connection
$con = mysqli_connect($host, $username, $password, $dbname, $port);

// Check connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
    echo "Database connected successfully.";
}

// Check if the form was submitted


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['Email'], $_POST['Password'])) {
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];

        if (!empty($Email) && !empty($Password) && !is_numeric($Email)) {
            // Query to check if the user exists
            $query = "SELECT * FROM toll_employee WHERE Email = '$Email' LIMIT 1";
            $result = mysqli_query($con, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);

                    if ($user_data['Password'] === $Password) {
                        // Redirect to dashboard on successful login
                        header("Location: tolldashboard.php");
                        exit;
                    }
                }
            }
            echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
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
    <title>Tollgate Employee Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="SignUp">
        <h1>Login</h1>
        <h4>For Tollgate Employee</h4>
        <form method="POST" action="">
            <label>Email</label>
            <input type="email" name="Email" required>
            <label>Password</label>
            <input type="password" name="Password" required>
            <input type="submit" value="Submit">
        </form>
        <p>Don't have an account? <a href="tollsignup.php">Sign Up Here</a></p>
    </div>
</body>
</html>
