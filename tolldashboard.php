<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];

    if ($fileError === 0) {
        $fileDestination = 'uploads/' . $fileName;

        // Move the file to the uploads directory
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // Connect to the database
            $conn = new mysqli('localhost', 'username', 'password', 'empregister');

            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            // Insert into database
            $stmt = $conn->prepare("INSERT INTO scannedtag (file_name, upload_time) VALUES (?, NOW())");
            $stmt->bind_param('s', $fileName);

            if ($stmt->execute()) {
                echo "File uploaded and stored in the database successfully!";
            } else {
                echo "Database error: " . $conn->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Failed to move the uploaded file.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toll Employee Dashboard</title>
    <link rel="stylesheet" href="tollhome.css">
    <script src="tolldash.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

</head> 
<body>
    <div class="dashboard">
        <!-- Navigation Bar -->
        <nav>
            <ul>
                <li data-section="home">Home</li>
                <li data-section="scanRFID">Scan RFID Tag</li>
                <li data-section="openedGates">View Open Gates</li>
                <li data-section="paymentHistory">View Toll Payment History</li>
                <li data-section="manageAccount">Manage Account</li>
                <li data-section="logout">Logout</li>
            </ul>
        </nav>

        <!-- Content Area -->
        <div id="content">
            <!-- Home Section -->
<!-- Home Section -->
<div id="home">
    <h2>Welcome to the Toll Employee Dashboard</h2>
    <div style="display: flex; justify-content: left; gap: 20px; margin: 20px 0;">
        <img src="images/pic15.jpg" alt="First Image" style="width: 150%; max-width: 600px; border-radius: 10px;">
        <img src="images/pic16.jpg" alt="Second Image" style="width: 70%; max-width: 400px; border-radius: 10px;">
    </div>
    <p>Your role is to ensure seamless tollgate operations, including verifying payments, managing vehicle access, and maintaining records.</p>

    <!-- Button linking to Scan RFID Tag Section -->
    <button class="btn" onclick="showSection('scanRFID')">Scan RFID TAG For Vehicle</button>
</div>

            <!-- Scan RFID Tag Section -->
            <div id="scanRFID" class="hidden">
    <h2>Scan RFID Tag</h2>
    <p>Use this section to verify payments and open gates. Ensure the RFID tag payment is valid before allowing access.</p>
    <button onclick="openGate()">Open Gate</button>
     
    <h3>Drag & Drop File Section</h3>
    <div id="file-drop-area" ondragover="handleDragOver(event)" ondrop="handleFileDrop(event)">
        <p>Drag and drop a file here or click to browse.</p>
        <input type="file" id="file-input" onchange="handleFileUpload(event)" hidden>
        <button onclick="document.getElementById('file-input').click()">Browse</button>
    </div>
    <div id="upload-status"></div>

    <h3>Payment History for Scanned Tag:</h3>
101728312024-12-13


    <!-- Square box for camera display -->
    <div id="camera-container">
        <div id="camera-box">
            <!-- The video element where the live camera feed will appear -->
            <video id="barcode-scanner" autoplay></video>
        </div>
    </div>

    <!-- "Scan RFID Tag" button below the camera box -->
    <button id="scan-button" onclick="startScanning()">Scan RFID Tag</button>

    <p id="scanned-result">VEHICLE TAG SCCANNED!.</p>
    <button id="stop-scan" style="display: none;" onclick="stopScanning()">Stop Scanning</button>
</div>
 
 
            <!-- View Open Gates Section -->
            <div id="openedGates" class="hidden">
                <h2>View Open Gates</h2>
                <div style="display: flex; justify-content: left; gap: 20px; margin: 20px 0;">
        <img src="images/pic10.jpg" alt="First Image" style="width: 70%; max-width: 300px; border-radius: 10px;">
        <img src="images/pic5.jpg" alt="Second Image" style="width: 70%; max-width: 300px; border-radius: 10px;">
    </div>
                <p>Here is the list of previously opened gates:</p>
                <table border ="3">
                    <tr>
                        <th>Vehicle Owner</th>
                        <th>Car Description</th>
                        <th>Gate Opened Date</th>
                    </tr>
                    <tr>
                        <td>John Doe</td>
                        <td>SUV - Blue</td>
                        <td>2024-11-16</td>
                    </tr>
                </table>
            </div>

            <!-- View Toll Payment History Section -->
            <divZ id="paymentHistory" class="hidden">
                <h2>View Toll Payment History</h2>
                <p>List of all toll payments processed by this employee:</p>
                <ul>
                    <li>Payment ID: #1234 - Amount: ZMW 20 - Date: 2024-11-16</li>
                    <li>Payment ID: #1235 - Amount: ZMW 50- Date: 2024-11-15</li>
                </ul>
            </divZ

            <!-- Manage Account Section -->
            <div id="manageAccount" class="hidden">
                <h2>Manage Account</h2>
                <p>Update your profile and account settings here:</p>
                <form>
                    <label>Name:</label>
                    <input type="text" placeholder="Enter your name">
                    <label>Email:</label>
                    <input type="email" placeholder="Enter your email">
                    <label>Password:</label>
                    <input type="password" placeholder="Enter a new password">
                    <button type="submit">Save Changes</button>
                </form>
            </div>

            <!-- Logout Section -->
            <div id="logout" class="hidden">
                <h2>Logout</h2>
                <p>Click below to log out of your account.</p>
                <form method="POST" action="tollemployeelogin.php">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <script src="tolldash.js"></script>
</body>
</html>
