<?php
// Start session
session_start();

// Database connection
$host = "localhost";     // Update if using a different host
$username = "root";      // Database username
$password = "";          // Database password
$database = "vehicle_ownerdb"; // Database name
$port = 3307;            // Adjust port number if needed

$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user inputs
    $RFIDtag = $conn->real_escape_string($_POST['rfid']);
    $vehname = $conn->real_escape_string($_POST['vehname']);
    $vehcolor = $conn->real_escape_string($_POST['vehcolor']);
    $vehplate = $conn->real_escape_string($_POST['vehplate']);
    $payclass = $conn->real_escape_string($_POST['payclass']);
    $vehtype = $conn->real_escape_string($_POST['vehtype']);

    // Insert data into vehdashboard table
    $sql = "INSERT INTO vehdashboard (RFIDtag, vehname, vehcolor, vehplate, payclass, vehtype) 
            VALUES ('$RFIDtag', '$vehname', '$vehcolor', '$vehplate', '$payclass', '$vehtype')";

    if ($conn->query($sql) === TRUE) {
        // If the insertion is successful, display success message and redirect
        echo "<script>alert('RFID Tag and Vehicle Details Added Successfully!');</script>";
        echo "<script>window.location.href = 'vehdashboard.php';</script>"; // Redirect to the dashboard
    } else {
        // If there's an error, display the error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
