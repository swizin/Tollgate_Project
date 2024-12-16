<?php
// Start session
session_start();

// Fetch session variables


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


// Assuming the user's email is stored in the session when they log in
if (isset($_SESSION['email'])) {
    $Email = $_SESSION['email'];  // Get the logged-in user's email from the session

    // Query to get user information from the database
    $sql = "SELECT * FROM vehicleregister WHERE Email = '$Email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Store the fetched data
        $userData = $result->fetch_assoc();
    } else {
        echo "No user found with that email.";
    }
    
    // Check if the user data is available
    if (isset($userData)) {
        echo "<h2>Your Profile</h2>";
        echo "<p><strong>Name:</strong> " . $userData['FirstName'] . " " . $userData['LastName'] . "</p>";
        echo "<p><strong>Email:</strong> " . $userData['Email'] . "</p>";
        echo "<p><strong>Driving License:</strong> " . $userData['DrivingLicense'] . "</p>";
        echo "<p><strong>Car Number Plate:</strong> " . $userData['CarNumberPlate'] . "</p>";
    }
    
} 
// Fetch RFID data
$rfidData = [];
$sqlRFIDtag = "SELECT * FROM vehdashboard";
$resultRFID = $conn->query($sqlRFIDtag);

if ($resultRFID->num_rows > 0) {
    while ($row = $resultRFID->fetch_assoc()) {
        $rfidData[] = $row;
    }
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Owner Home Page</title>
    <link rel="stylesheet" href="vehhome.css">
    <script src="vehhome.js"></script>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
}

/* Navigation bar styles */
.navbar {
    display: flex;
    justify-content: space-around;
    align-items: center;
    background-color: #333;
    padding: 10px 20px;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.navbar a {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    font-size: 16px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar a:hover {
    background-color: #575757;
    border-radius: 5px;
    color: #e2e2e2;
}

/* Content area styles */
.content {
    margin-top: 20px;
    padding: 20px;
    text-align: center;
}

section {
    display: none; /* Initially, all sections are hidden */
    margin-top: 20px;
}

section.active {
    display: block; /* Show the active section */
}

h1 {
    color: #333;
    margin-bottom: 20px;
}

p {
    color: #555;
}
/* Button styling */
.btn {
    background-color: #4CAF50; /* Green background */
    color: white;             /* White text */
    padding: 10px 20px;       /* Padding for better spacing */
    font-size: 16px;          /* Font size */
    border: none;             /* Remove borders */
    border-radius: 5px;       /* Rounded corners */
    cursor: pointer;          /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth color change */
}

.btn:hover {
    background-color: #1440d3; /* Darker green on hover */
}

.btn:focus {
    outline: none; /* Remove focus outline */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); /* Add a subtle shadow on focus */
}
/* Style the RFID form with side-by-side background images */
.rfid-form {
    background: url('images/pic1.jpg') left top / 50% auto no-repeat, 
                url('images/pic2.jpg') right top / 50% auto no-repeat; /* Side-by-side images */
    padding: 20px; /* Add padding for content spacing */
    border: 1px solid #ccc; /* Optional border for clarity */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    background-color: rgba(255, 255, 255, 0.8); /* Slight white overlay for readability */
}

/* Style the input fields and labels */
.rfid-form label {
    display: block;
    font-weight: bold;
    margin-top: 15px;
    color: #333;
}

.rfid-form input[type="text"],
.rfid-form input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box; /* Ensure proper box sizing */
}

/* Style the submit button */
.rfid-form input[type="submit"] {
    background-color: #4CAF50; /* Green background */
    color: white; /* White text */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth hover effect */
}

.rfid-form input[type="submit"]:hover {
    background-color: #45a049; /* Darker green on hover */
}

/* Optional: Style the hint text */
.rfid-form .hint {
    font-size: 12px;
    color: #777;
    margin-top: -8px;
    margin-bottom: 10px;
}



/* Responsive design */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
    }

    .navbar a {
        margin-bottom: 5px;
    }
}
/* Style for the email label in the payment section */
.payment-section label[for="email"] {
    font-size: 16px; /* Adjust font size for readability */
    font-weight: bold; /* Make the label text bold */
    color: #4CAF50; /* Use a green color to match the theme */
    text-transform: uppercase; /* Convert text to uppercase for emphasis */
    letter-spacing: 1px; /* Add spacing between letters */
    margin-bottom: 10px; /* Add some spacing below the label */
    display: inline-block; /* Ensure proper alignment with input fields */
}

/* Add hover effect for the label */
.payment-section label[for="email"]:hover {
    color: #1440d3; /* Change color on hover */
    cursor: pointer; /* Indicate interactivity */
}

/* Style the email input field */
.payment-section input[type="email"] {
    width: 100%; /* Full width for better usability */
    padding: 10px; /* Add padding for comfortable input */
    font-size: 14px; /* Font size for text clarity */
    border: 1px solid #ccc; /* Light gray border */
    border-radius: 5px; /* Rounded corners for a modern look */
    box-sizing: border-box; /* Ensure padding doesn't affect width */
    margin-top: 5px; /* Space between label and input */
    margin-bottom: 15px; /* Space below the input */
    transition: border-color 0.3s ease; /* Smooth border color change */
}

/* Highlight the input field when focused */
.payment-section input[type="email"]:focus {
    border-color: #4CAF50; /* Green border on focus */
    outline: none; /* Remove the default outline */
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5); /* Subtle green glow */
}


</style>
    <script>
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => section.style.display = 'none');

            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
        }

        // Show "home" section by default on page load
        window.onload = () => {
            showSection('home');
        };
    </script>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
    <a href="#" onclick="showSection('home')">Home</a>
    <a href="#" onclick="showSection('addRFID')">Add RFID Tag</a>
    <a href="#" onclick="showSection('makePayment')">Make Payment</a>
    <a href="#" onclick="showSection('viewPaidGates')">View Paid Gates</a>
    <a href="#" onclick="showSection('paymentHistory')">Payment History</a>
    <a href="#" onclick="showSection('manageAccount')">Manage Account</a>
    <a href="logout.php">Logout</a>
</div>

    <!-- Main Content -->
     
    
    <div id="home" class="section active">
    <h1>Welcome to Your Dashboard</h1>
    <!-- Add a container for side-by-side images -->
    <div style="display: flex; justify-content: left; gap: 20px; margin: 20px 0;">
        <img src="images/pic2.jpg" alt="First Image" style="width: 150%; max-width: 600px; border-radius: 10px;">
        <img src="images/pic9.jpg" alt="Second Image" style="width: 100%; max-width: 400px; border-radius: 10px;">
    </div>
    
    
    <p>Here you can manage all your tollgate-related actions in one place.</p>
    <!-- Modified button to link to the Add RFID Tag section -->
    <button class="btn" onclick="showSection('addRFID')">Add RFID TAG & Vehicle Details</button>
</div>   
    </div>
</div>

    </div>
    

        </div>
    </div>


        <!-- Add RFID Tag Section -->
        <div id="addRFID" class="section" style="display: none;">
    <h1>Add RFID Tag</h1>
    <div style="display: flex; justify-content: left; gap: 20px; margin: 20px 0;">
        <img src="images/pic4.jpg" alt="First Image" style="width: 90%; max-width: 120px; border-radius: 10px;">
    </div>
    <form method="POST" action="submitrfid.php">
        <!-- RFID Tag Number -->
        <label for="rfid">RFID Tag Number:</label>
        <input type="text" id="rfid" name="rfid" placeholder="Enter RFID tag number" required>
        <p class="hint" id="rfid-hint">This is a unique number printed on your RFID tag.</p>
        
        <!--rfid tag Vehicle Name -->
        <label for="vehname">Vehicle Name:</label>
        <input type="text" id="vehname" name="vehname" placeholder="Enter vehicle name" required>
        <p class="hint" id="vehname-hint">Enter the brand and model of your vehicle (e.g., Toyota Corolla).</p>
        
        <!-- rfid tag Vehicle Color -->
        <label for="vehcolor">Vehicle Color:</label>
        <input type="text" id="vehcolor" name="vehcolor" placeholder="Enter vehicle color" required>
        <p class="hint" id="vehcolor-hint">Specify the color of your vehicle (e.g., Red, Blue, Black).</p>
        
        <!--rfid tag Vehicle Plate Number -->
        <label for="vehplate">Vehicle Plate Number:</label>
        <input type="text" id="vehplate" name="vehplate" placeholder="Enter vehicle plate number" required>
        <p class="hint" id="vehplate-hint">Provide the license plate number of your vehicle.</p>
        
        <!-- Payment Class -->
        <label for="payclass">Payment Class:</label>
        <select id="payclass" name="payclass" required>
            <option value="" disabled selected>-- Select Payment Class --</option>
            <option value="Class A">Class A ZMW 20 </option>
            <option value="Class B">Class B ZMW 50 </option>
            <option value="Class C">Class C ZMW 80</option>
            <option value="Class D">Class D ZMW 150 </option>
            <option value="Class E">Class E ZMW 500 </option>
        </select>
        <p class="hint" id="payclass-hint">Choose the payment class for your vehicle type.</p>
        
        <!--payment Vehicle Type -->
        <label for="vehtype">Vehicle Type:</label>
        <select id="vehtype" name="vehtype" required>
            <option value="" disabled selected>-- Select Vehicle Type --</option>
            <option value="Class A">Class A (Private small vehicles & 16-30 seat Mini-buses)</option>
            <option value="Class B">Class B (Light vehicles with 2-3 Axles, e.g., Fuso, canters, vans)</option>
            <option value="Class C">Class C (Buses over 30 seats with 3 axles or more)</option>
            <option value="Class D">Class D (Heavy Trucks with or above 4 axles)</option>
            <option value="Class E">Class E (All abnormal loads)</option>
        </select>
        <p class="hint" id="vehtype-hint">Select the vehicle type that matches your description.</p>
        
        <input type="submit" value="Submit">
    </form>
</div>

        
        <!-- Make Payment Section -->
         
<div id="makePayment" class="section" style="display: none;">
    <h1>Make Payment</h1>
    <p>Enter your payment details below to proceed:</p>
   

    <!-- Payment Form -->
    <form method="POST" action="process_payment.php">
        <!-- Display Transaction ID (generated automatically) -->
        <?php 
        // Generate a unique transaction ID
        $transaction_id = uniqid('TXN-');
        echo '<input type="hidden" name="transaction_id" value="' . $transaction_id . '">';
        ?>

        <!-- Email (read-only, fetched from session) -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" readonly required>
        
 
        <!-- Payment Reference (generated automatically) -->
        <!-- Payment Amount (calculated based on payclass) -->
        <!-- Payment Class Selection -->
        <label for="payclass">Select Payment Class:</label>
        <select id="payclass" name="payclass" required>
            <option value="" disabled selected>-- Select Payment Class --</option>
            <option value="Class A">Class A - ZMW 20.00</option>
            <option value="Class B">Class B - ZMW 50.00</option>
            <option value="Class C">Class C - ZMW 80.00</option>
            <option value="Class D">Class D - ZMW 150.00</option>
            <option value="Class E">Class E - ZMW 500.00</option>
        </select>

        <!-- Payment Method Selection -->
        <label for="payment_method">Choose Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="" disabled selected>-- Select Payment Method --</option>
            <option value="paypal">PayPal</option>
            <option value="mtn">MTN Mobile Money</option>
            <option value="airtel">Airtel Mobile Money</option>
            <option value="zamtel">Zamtel Mobile Money</option>
        </select>

        <!-- Amount (calculated based on payclass) -->
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" placeholder="Enter Amount" required>

        <!-- Submit Button -->
        <input type="submit" value="Make Payment">
    </form>
</div>


        <!-- View Paid Gates Section -->
        <div id="viewPaidGates" class="section" style="display: none;">
            <h1>View Paid Gates</h1>
            <p>Here is the list of tollgates you have already paid for:</p>
            <ul>
                <li>Kabwe Tollgate </li>
                <li>Ndola Tollgate </li>
                <li>Mfumbu Tollgate </li>
                <li>Monze Tollgate </li>
                <li>Mbala Tollgate </li>
                <li>Kafue Tollgate </li>
                <li>Mazabuka Tollgate </li>
                <li>Chongwe Tollgate </li>
                <li>Chipata Tollgate </li>
            </ul>
        </div>

        <!-- Payment History Section -->
        <div id="paymentHistory" class="section" style="display: none;">
            <h1>Payment History</h1>
            <p>Check your transaction history below:</p>
            <ul>
                <li>Payment on 2024-11-01: K20</li>
                <li>Payment on 2024-11-10: K20</li>
                <li>Payment on 2024-11-14: K20</li>
                <li>Payment on 2024-11-21: K20</li>
                <li>Payment on 2024-12-01: K20</li>
                <li>Payment on 2024-12-04: K20</li>
                <li>Payment on 2024-12-10: K20</li>
                <li>Payment on 2024-12-14: K20</li>
            </ul>
        </div>

        <!-- Manage Account Section -->
        <div id="manageAccount" class="section" style="display: none;">
            <h1>Manage Account</h1>
            <p>Update your account details below:</p>
            <form>
                <label for="Email">Email:</label>
                <input type="Email" id="Email" name="Email" placeholder="Update Email" required>
                <label for="Password">Password:</label>
                <input type="Password" id="Password" name="Password" placeholder="Update Password" required>
                <input type="submit" value="Update Account">
            </form>
        </div>
    </div>
</body>
</html>
