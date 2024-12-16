document.addEventListener("DOMContentLoaded", function () {
    const navItems = document.querySelectorAll("nav ul li");
    const sections = document.querySelectorAll(".dashboard > #content > div");

    navItems.forEach((item) => {
        item.addEventListener("click", function () {
            const target = item.getAttribute("data-section");

            sections.forEach((section) => {
                section.classList.add("hidden");
                if (section.id === target) {
                    section.classList.remove("hidden");
                }
            });
        });
    });
});
// tolldash.js
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('#content > div');
    sections.forEach(section => {
        section.classList.add('hidden');
    });

    // Show the selected section
    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
        selectedSection.classList.remove('hidden');
    }
}

// Optional: Add this for initialization to display the 'home' section by default
document.addEventListener('DOMContentLoaded', () => {
    showSection('home');
});

function openGate() {
    alert("Gate opened successfully!");
    const paymentHistory = document.getElementById("paymentHistory");
    const newEntry = document.createElement("li");
    newEntry.textContent = "RFID Tag #1234: Payment verified.";
    paymentHistory.appendChild(newEntry);
}

document.addEventListener("DOMContentLoaded", function () {
    const navItems = document.querySelectorAll("nav ul li");
    const sections = document.querySelectorAll(".dashboard > #content > div");

    navItems.forEach((item) => {
        item.addEventListener("click", function () {
            const target = item.getAttribute("data-section");

            sections.forEach((section) => {
                section.classList.add("hidden");
                if (section.id === target) {
                    section.classList.remove("hidden");
                }
            });
        });
    });
});

function openGate() {
    alert("Gate opened successfully!");
    const paymentHistory = document.getElementById("paymentHistory");
    const newEntry = document.createElement("li");
    newEntry.textContent = "RFID Tag #1234: Payment verified.";
    paymentHistory.appendChild(newEntry);
}
function startScanning() {
    const videoElement = document.getElementById('barcode-scanner'); // Get the video element
    const resultElement = document.getElementById('scanned-result'); // For displaying the scanned result

    // Hide the "Scan RFID Tag" button and show the "Stop Scanning" button
    document.getElementById('scan-button').style.display = 'none';
    document.getElementById('stop-scan').style.display = 'block';

    // Initialize QuaggaJS
    Quagga.init(
        {
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: videoElement, // Video feed element
                constraints: {
                    facingMode: "environment", // Use back camera
                },
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "ean_8_reader"], // Supported barcode types
            },
        },
        function (err) {
            if (err) {
                console.error("Error initializing Quagga:", err);
                alert("Failed to start scanner.");
                return;
            }
            Quagga.start();
            console.log("Barcode scanner started.");
        }
    );

    // Handle detected barcodes
    Quagga.onDetected((data) => {
        const barcode = data.codeResult.code; // Extract the barcode
        console.log("Barcode detected:", barcode);

        // Display the scanned barcode
        resultElement.textContent = `Scanned Barcode: ${barcode}`;
        
        // Optionally, stop the scanner after a successful scan
        stopScanning();
    });
}


// Function to start scanning (access the camera and show live feed)


// Function to stop scanning (stop the camera feed)
function stopScanning() {
    const videoElement = document.getElementById('barcode-scanner');  // Get the video element
    const stream = videoElement.srcObject;
    const tracks = stream.getTracks();

    // Stop all video tracks to end the video stream
    tracks.forEach(track => track.stop());

    // Hide the "Stop Scanning" button and show the "Scan RFID Tag" button again
    document.getElementById('scan-button').style.display = 'block';
    document.getElementById('stop-scan').style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    const navItems = document.querySelectorAll("nav ul li");
    const sections = document.querySelectorAll(".dashboard > #content > div");

    // Navigation items click handler
    navItems.forEach((item) => {
        item.addEventListener("click", function () {
            const target = item.getAttribute("data-section");

            sections.forEach((section) => {
                section.classList.add("hidden");
                if (section.id === target) {
                    section.classList.remove("hidden");
                }
            });
        });
    });
});

// Function to open the gate
function openGate() {
    alert("Gate opened successfully!");
    const paymentHistory = document.getElementById("paymentHistory");
    const newEntry = document.createElement("li");
    newEntry.textContent = "RFID Tag #1234: Payment verified.";
    paymentHistory.appendChild(newEntry);
}

// Function to start scanning (access the camera and show live feed)
function startScanning() {
    const videoElement = document.getElementById('barcode-scanner');  // Get the video element
    const cameraBox = document.getElementById('camera-box');  // Get the camera box element

    // Hide the "Scan RFID Tag" button once scanning starts
    document.getElementById('scan-button').style.display = 'none';
    document.getElementById('stop-scan').style.display = 'block';  // Show the Stop Scanning button

    // Request access to the camera
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then((stream) => {
            // Assign the video stream to the video element
            videoElement.srcObject = stream;
            videoElement.play();
        })
        .catch((error) => {
            // If there is an error, log it to the console
            console.error("Error accessing the camera: ", error);
            alert("Camera access denied or not available.");
        });
}

// Function to stop scanning (stop the camera feed)
function stopScanning() {
    const videoElement = document.getElementById('barcode-scanner');  // Get the video element
    const stream = videoElement.srcObject;
    
    if (stream) {
        const tracks = stream.getTracks();
        tracks.forEach(track => track.stop());  // Stop all video tracks to end the video stream
    }

    // Hide the "Stop Scanning" button and show the "Scan RFID Tag" button again
    document.getElementById('scan-button').style.display = 'block';
    document.getElementById('stop-scan').style.display = 'none';
}
function handleDragOver(event) {
    event.preventDefault();
    event.target.style.border = "2px dashed green";
}

function handleFileDrop(event) {
    event.preventDefault();
    event.target.style.border = "2px dashed gray";
    const file = event.dataTransfer.files[0];
    uploadFile(file);
}

function handleFileUpload(event) {
    const file = event.target.files[0];
    uploadFile(file);
}

function uploadFile(file) {
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    fetch('uploadFile.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('upload-status').innerText = data;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('upload-status').innerText = 'File upload failed.';
        });
}
