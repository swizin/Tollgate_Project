<?php
// Start session
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "vehicle_ownerdb";
$port = 3307;

$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $transaction_id = $conn->real_escape_string($_POST['transaction_id']);
    $email = $conn->real_escape_string($_POST['email']);
    $payclass = $conn->real_escape_string($_POST['payclass']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $created_at = date('Y-m-d H:i:s'); // Current timestamp

    // Insert data into the payments table
    $sql = "INSERT INTO payments (transaction_id, email, payclass, payment_method, amount, created_at) 
            VALUES ('$transaction_id', '$email', '$payclass', '$payment_method', '$amount', '$created_at')";

    if ($conn->query($sql) === TRUE) {
        echo "Payment successful! Transaction ID: $transaction_id";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Close connection
$conn->close();
?>
