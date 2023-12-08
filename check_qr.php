<?php
// Connect to the database (use your database details)
$host = 'localhost';
$user = 'root';
$pwd = ''; // Change this to your database password
$db = 'booking';
$conn = new mysqli($host, $user, $pwd, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive QR code data from ESP32-CAM
$qrData = $_GET["qrData"];

// Query the database to verify the QR code
$sql = "SELECT * FROM user WHERE VehicleNumber = '$qrData'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // QR code matched a database entry
    echo "SUCCESS";
} else {
    // QR code not found in the database
    echo "FAILURE";
}

$conn->close();
?>
